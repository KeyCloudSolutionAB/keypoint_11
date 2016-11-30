<?php

class SellerController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'send_mail'),
                'roles' => array('customer'),
            ),
            array('allow',
                'actions' => array('create', 'update'),
                'roles' => array('customer'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('customer'),
            ),
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
        $model = new Seller;
        $model->setScenario('seller');

        if (isset($_POST['Seller'])) {
            $model->attributes = $_POST['Seller'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $mail = $model->email;
        if (isset($_POST['Seller'])) {
            $model->attributes = $_POST['Seller'];
            $uniq_mail = Seller::model()->resetScope()->findByAttributes(array('email' => $model->email));
            if (!empty($uniq_mail)) {
                if ($uniq_mail->email == $mail) {
                    if ($model->save())
                        $this->redirect(array('view', 'id' => $model->id));
                }else {
                    Yii::app()->user->setFlash('error', Yii::t("translation", "mail_has_already_been_taken"));
                    $this->refresh();
                }
            } else {
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
            }
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
        $model = new Seller('search');
        $model->unsetAttributes();
        if (isset($_GET['Seller']))
            $model->attributes = $_GET['Seller'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionSend_mail($id) {
        $model = $this->loadModel($id);

        if ($model->status == 0) {
            $bool = $model->sendMailNewPassword();
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "mail_sent_successfully"));
                $this->redirect(array('index'));
            }
        } else {
            $bool = $model->sendMailNewPassword2();
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "mail_sent_successfully"));
                $this->redirect(array('index'));
            }
        }
    }

    public function loadModel($id) {
        $model = Seller::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
