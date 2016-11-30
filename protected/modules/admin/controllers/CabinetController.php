<?php

class CabinetController extends Controller {

    public function actionIndex() {
        $model = User::model()->resetScope()->findByPk(Yii::app()->user->id);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if (!empty($model->new_pass)) {
                $model->password = md5($model->new_pass);
                if ($model->saveAttributes(array('name', 'phone', 'lang', 'password'))) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                    $this->refresh();
                }
            } else {
                if ($model->saveAttributes(array('name', 'phone', 'lang'))) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                    $this->refresh();
                }
            }
        }

        $this->render('index', array('model' => $model));
    }

}
