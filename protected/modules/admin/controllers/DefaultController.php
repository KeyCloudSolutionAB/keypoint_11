<?php

class DefaultController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'image', 'top', 'missing', 'filters'),
                'roles' => array('administrator'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionFilters() {

        if (isset($_POST['reset_all'])) {
            $all = FilterScorlist::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
            $all = FilterCategory::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
            $all = FilterTags::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
            Yii::app()->user->setFlash('reset', Yii::t("translation", "successfully_updated_information"));
            $this->refresh();
        }


        if (isset($_POST['save'])) {
            $bool = FALSE;

            if (isset($_POST['scorlist'])) {
                $all = FilterScorlist::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));


                $scorlist = $_POST['scorlist'];
                foreach ($scorlist as $key => $value) {
                    $model = new FilterScorlist;
                    $model->scoring_id = $value;
                    $model->user_id = Yii::app()->params['choose_customer'];
                    $model->save();
                }
                $bool = TRUE;
            }

            if (isset($_POST['category'])) {
                $all = FilterCategory::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));


                $category = $_POST['category'];
                foreach ($category as $key => $value) {
                    $model = new FilterCategory;
                    $model->store_category_id = $value;
                    $model->user_id = Yii::app()->params['choose_customer'];
                    $model->save();
                }
                $bool = TRUE;
            }

            if (isset($_POST['tags'])) {
                $all = FilterTags::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));


                $tags = $_POST['tags'];
                foreach ($tags as $key => $value) {
                    $model = new FilterTags;
                    $model->tag_id = $value;
                    $model->user_id = Yii::app()->params['choose_customer'];
                    $model->save();
                }
                $bool = TRUE;
            }

            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                $this->refresh();
            }
        }



        $model_filter_scorlist = new FilterScorlist;
        $model_filter_category = new FilterCategory;
        $model_filter_tags = new FilterTags;


        $this->render('filters', array(
            'model_filter_scorlist' => $model_filter_scorlist,
            'model_filter_category' => $model_filter_category,
            'model_filter_tags' => $model_filter_tags,
        ));
    }

    public function actionIndex() {


        if (isset($_GET['delete_share_link'])) {
            if ($_GET['delete_share_link'] == 'ok') {
                $criteria = new CDbCriteria;
                $criteria->order = 'id DESC';
                $criteria->condition = 'status = 1';
                $dashboard_link = Dashboard::model()->find($criteria);
                if ($dashboard_link->delete()) {
                    $this->redirect(array('default/index'));
                }
            }
        }

        $active = TRUE;
        if (isset($_GET['active'])) {
            if ($_GET['active'] == 'no') {
                $active = FALSE;
            }
        }

        $everage_mesured_store = FALSE;
        if (isset($_GET['everage_active'])) {
            if ($_GET['everage_active'] == 'yes') {
                $everage_mesured_store = TRUE;
            }
        }


        if (!$active) {
            $criteria = new CDbCriteria;
            $criteria->order = 'title ASC';
            $criteria->condition = 'status = 0';
            $models = Scoring::model()->findAll($criteria);
        } else {
            $date = date("Y-m-d H:i:s");
            $criteria = new CDbCriteria;
            $criteria->order = 'title ASC';
            $criteria->condition = '`start_time` <= "' . $date . '" AND `end_time` >= "' . $date . '" AND `status` = 0';
            $models = Scoring::model()->findAll($criteria);
        }
        
     

        $filter_scorlist = FilterScorlist::model()->checkScorings(Yii::app()->params['choose_customer']);
        if (!empty($filter_scorlist)) {
            foreach ($models as $key => $value) {
                if (array_key_exists($value->id, $filter_scorlist)) {
                    
                } else {
                    unset($models[$key]);
                }
            }
        }
        // 
        $filter_category = FilterCategory::model()->checkCategories(Yii::app()->params['choose_customer']);
        if (!empty($filter_category)) {
            foreach ($models as $key => $value) {
                $scoring_category_all = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $value->id)); // Получаем все категории
                $scoring_category_list = CHtml::listData($scoring_category_all, 'store_category_id', 'scoring_id');

                $new_array = array_intersect_key($scoring_category_list, $filter_category);
                if (!empty($new_array)) {
                    
                } else {
                    unset($models[$key]);
                }
            }
        }
        // 
        $filter_tag = FilterTags::model()->checkTags(Yii::app()->params['choose_customer']);
        if (!empty($filter_tag)) {
            foreach ($models as $key => $value) {
                $scoring_tag_all = ScoringTag::model()->findAllByAttributes(array('scoring_id' => $value->id)); // Получаем все теги
                $scoring_tag_list = CHtml::listData($scoring_tag_all, 'tag_id', 'tag_id');

                $new_array = array_intersect_key($scoring_tag_list, $filter_tag);
                if (!empty($new_array)) {
                    
                } else {
                    unset($models[$key]);
                }
            }
        }

        if (!empty($_POST['search_seller'])) {
            $search_seller = CHtml::encode($_POST['search_seller']);
            $total_scorings = TotalScoring::model()->getAdminRecentActivety($search_seller);
        } else {
            $total_scorings = TotalScoring::model()->AdminRecentActivety;
        }





        $dashboard_links = Dashboard::model()->findAllByAttributes(array('status' => '1'));



        $this->render('index', array(
            'models' => $models,
            'active' => $active,
            'total_scorings' => $total_scorings,
            'everage_mesured_store' => $everage_mesured_store,
            'dashboard_links' => $dashboard_links,
        ));
    }

    public function actionView($id, $mesured = FALSE) {
        $model = $this->loadModel($id);
        if ($mesured) {
            $models = $model->MesuredStores;
        } else {
            $models = $model->PossibleStore;
        }

        $pagesize = 10;
        if (isset($_GET['page_size'])) {
            $pagesize = (int) $_GET['page_size'];
        }

        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'attributes' => array(
                    'id',
                ),
            ),
            'pagination' => array(
                'pageSize' => $pagesize,
            ),
        ));


        $this->render('view', array('model' => $model, 'models' => $dataProvider));
    }

    public function actionImage($id) {
        $model = $this->loadModel($id);
        $models = $model->ImageStore;
        $this->render('image', array('model' => $model, 'models' => $models));
    }

    public function actionTop($id = NULL) {
        if (!empty($id)) {
            $model = $this->loadModel($id);
            if (!empty($model->id)) {
                $models = TotalScoring::model()->getTopSellers($model->id);
            } else {
                $models = TotalScoring::model()->TopSellers;
            }
        } else {
            $model = NULL;
            $models = TotalScoring::model()->TopSellers;
        }

        $this->render('top', array('model' => $model, 'models' => $models));
    }

    public function actionMissing($id) {
        $model = $this->loadModel($id);
        $models = $model->ListMissingStore;

        $pagesize = 10;
        if (isset($_GET['page_size'])) {
            $pagesize = (int) $_GET['page_size'];
        }

        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'attributes' => array(
                    'id',
                ),
            ),
            'pagination' => array(
                'pageSize' => $pagesize,
            ),
        ));



        $this->render('missing', array('model' => $model, 'models' => $dataProvider));
    }

    public function loadModel($id) {
        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
