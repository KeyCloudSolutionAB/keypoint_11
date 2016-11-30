<?php

class DashboardController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'add'),
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
        $model = new Dashboard;

        if (isset($_POST['Dashboard'])) {
            $model->attributes = $_POST['Dashboard'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionAdd() {
        $url_link = $_SERVER['SERVER_NAME'] . '/' . Yii::app()->language . '/dashboard_share/index?key_id=';

        $model = new Dashboard;
        if ($model->save()) {
            echo Yii::t("translation", "dashboard_link") . ': <div id="dashboard_link_text">' . $url_link . $model->key . '</div> <button data-clipboard-target="#dashboard_link_text" id="dashboard_link_clipboard" type="submit" class="btn btn-default"><i class="fa fa-clipboard"></i></button>';
        }
        Yii::app()->end();
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Dashboard'])) {
            $model->attributes = $_POST['Dashboard'];
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
        $model = new Dashboard('search');
        $model->unsetAttributes();
        if (isset($_GET['Dashboard']))
            $model->attributes = $_GET['Dashboard'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Dashboard::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dashboard-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
