<?php

class Art_catController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'add', 'add2'),
                'roles' => array('administrator'),
            ),
//            array('allow',
//                'actions' => array('create', 'update', 'view'),
//                'roles' => array('administrator'),
//            ),
//            array('allow',
//                'actions' => array('delete'),
//                'roles' => array('administrator'),
//            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new ArtCat;

        if (isset($_POST['ArtCat'])) {
            $model->attributes = $_POST['ArtCat'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['ArtCat'])) {
            $model->attributes = $_POST['ArtCat'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex() {
        $model = new ArtCat('search');
        $model->unsetAttributes();
        if (isset($_GET['ArtCat']))
            $model->attributes = $_GET['ArtCat'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = ArtCat::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t("translation", "the_requested_page_does_not_exist"));
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'art-cat-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // ============================== //

    public function actionAdd() {
        $all_cat = StoreCategory::model()->findAll();
        $models = Article::model()->findAll();
        $model = new ArtCat;

        if (isset($_GET['store_category_id'])) {
            $store_category_id = (int) $_GET['store_category_id'];
            $model->store_category_id = $store_category_id;
        } else {
            if (isset($_POST['ArtCat'])) {
                $model->store_category_id = $_POST['ArtCat']['store_category_id'];
            } else {
                foreach ($model->AllStoreCategory as $key => $value) {
                    $model->store_category_id = $key;
                    break;
                }
            }
            $this->redirect(array('art_cat/add', 'store_category_id' => $model->store_category_id));
        }

        if (isset($_POST['ArtCat'])) {
            $model->store_category_id = $_POST['ArtCat']['store_category_id'];
            $this->redirect(array('art_cat/add', 'store_category_id' => $model->store_category_id));
        }


        $find_cat = StoreCategory::model()->findByPk($store_category_id);
        if ($find_cat === null) {
            throw new CHttpException(404, Yii::t("translation", "the_requested_page_does_not_exist"));
        }

        if (isset($_POST['ArrayArtCat'])) {
            $array = $_POST['ArrayArtCat'];
            $new_array = NULL;
            $bool = FALSE;

            foreach ($array as $key => $value) {
                if (!empty($value['value'])) {
                    $new_model = ArtCat::model()->findByAttributes(array('article_id' => $value['article_id'], 'store_category_id' => $store_category_id));
                    if (empty($new_model)) {
                        $new_model = new ArtCat;
                    }
                    $new_model->article_id = $value['article_id'];
                    $new_model->store_category_id = $store_category_id;
                    $new_model->value = $value['value'];
                    if ($new_model->save()) {
                        $bool = TRUE;
                    }
                } else {
                    $new_model = ArtCat::model()->findByAttributes(array('article_id' => $value['article_id'], 'store_category_id' => $store_category_id));
                    if (!empty($new_model)) {
                        $new_model->delete();
                    }
                }
            }
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information"));
                $this->refresh();
            }
        }



        $this->render('add', array(
            'model' => $model,
            'models' => $models,
            'all_cat' => $all_cat,
            'store_category_id' => $store_category_id
        ));
    }

    public function actionAdd2() {

        $all_cat = StoreCategory::model()->findAll();

        $store_category_id = NULL;

        $model_artcat = new ArtCat;

        if (isset($_GET['ArtCat']['store_category_id'])) {
            $model_artcat->store_category_id = (int) $_GET['ArtCat']['store_category_id'];
        }

        $model = new Article('search');
        $model->unsetAttributes();
        if (isset($_GET['Article']))
            $model->attributes = $_GET['Article'];

        if (!empty($model_artcat->store_category_id) && isset($_POST['ArticleID'])) {
            $bool = FALSE;
            $array = $_POST['ArticleID'];
            foreach ($array as $key => $value) {
                $new_model = ArtCat::model()->findByAttributes(array('article_id' => $key, 'store_category_id' => $model_artcat->store_category_id));
                if (empty($new_model)) {
                    $new_model = new ArtCat;
                    $new_model->article_id = $key;
                    $new_model->store_category_id = $model_artcat->store_category_id;
                }  else {
                    if(empty($value)){
                        $new_model->delete();
                        continue;
                    }
                }               
                $new_model->value = $value;
                if ($new_model->save()) {
                    $bool = TRUE;
                }
            }
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information"));
                $this->refresh();
            }
        }



        $this->render('add2', array(
            'model' => $model,
            'all_cat' => $all_cat,
            'model_artcat' => $model_artcat,
        ));
    }

}
