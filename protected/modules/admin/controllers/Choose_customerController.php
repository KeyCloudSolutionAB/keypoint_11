<?php

class Choose_customerController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array('administrator'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = AdminChoose::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
        if (empty($model)) {
            $model = new AdminChoose;
        }


        if (isset($_POST['AdminChoose'])) {
            $model->attributes = $_POST['AdminChoose'];
            if ($model->save()) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                $this->refresh();
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

}
