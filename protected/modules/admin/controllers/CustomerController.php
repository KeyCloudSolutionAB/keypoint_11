<?php

class CustomerController extends Controller {

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
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('create', 'update'),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('administrator'),
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
        $model = new Customer;
        $model->setScenario('customer');

        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->setScenario('customer');

        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
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
        $model = new Customer('search');
        $model->unsetAttributes();
        if (isset($_GET['Customer']))
            $model->attributes = $_GET['Customer'];
        //
        $admin_choose = AdminChoose::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
        if (empty($admin_choose)) {
            $admin_choose = new AdminChoose;
        }
        if (isset($_POST['AdminChoose'])) {
            $admin_choose->attributes = $_POST['AdminChoose'];
            if ($admin_choose->save()) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                $this->refresh();
            }
        }

        $this->render('index', array(
            'model' => $model,
            'admin_choose' => $admin_choose,
        ));
    }

    public function loadModel($id) {
        $model = Customer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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

}
