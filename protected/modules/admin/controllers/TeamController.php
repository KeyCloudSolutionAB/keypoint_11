<?php

class TeamController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
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
        $model = new Team;

        if (isset($_POST['Team'])) {
            $model->attributes = $_POST['Team'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Team'])) {
            $model->attributes = $_POST['Team'];
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
        $model = new Team('search');
        $model->unsetAttributes();
        if (isset($_GET['Team']))
            $model->attributes = $_GET['Team'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Team::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'team-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
