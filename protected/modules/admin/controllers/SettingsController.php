<?php

class SettingsController extends Controller {

    public function actionIndex() {
        $uniq = date("Y-m-d H") . '4gvh20f29';
        $uniq = md5($uniq);
        if (isset($_GET['key'])) {
            $key = CHtml::encode($_GET['key']);
            if ($key === $uniq) {
                $models = ArticleCategory::model()->findAll();
                foreach ($models as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }
                //

                $bool = FALSE;
                $models = Store::model()->findAll();
                foreach ($models as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                //
                $all = FilterScorlist::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
                $all = FilterCategory::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
                $all = FilterTags::model()->deleteAllByAttributes(array('user_id' => Yii::app()->params['choose_customer']));
                //
                $models_category = StoreCategory::model()->findAll();
                foreach ($models_category as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                //
                $models_sellers = Seller::model()->findAll();
                foreach ($models_sellers as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                //
                $models_tags = Tag::model()->findAll();
                foreach ($models_tags as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                //
                $models_team_name = TeamName::model()->findAll();
                foreach ($models_team_name as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }
                //
                $models_scoring = Scoring::model()->findAll();
                foreach ($models_scoring as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "delete_stores_successfully"));
                    $this->redirect(array('index'));
                }
            }
        }



        $this->render('index', array('uniq' => $uniq));
    }

    public function actionArticles() {
        $uniq = date("Y-m-d H") . '4gvh20f29';
        $uniq = md5($uniq);
        if (isset($_GET['key'])) {
            $key = CHtml::encode($_GET['key']);
            if ($key === $uniq) {
                $bool = FALSE;
                $models = ArticleCategory::model()->findAll();
                foreach ($models as $key => $value) {
                    $value->delete();
                    $bool = TRUE;
                    set_time_limit(10);
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "delete_stores_successfully"));
                    $this->redirect(array('index'));
                }
            }
        }

        $this->redirect(array('index'));
    }

}
