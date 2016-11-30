<?php

class TranslationController extends Controller {

    public function filters() {
        return array(
            'accessControl',          
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('create', 'update'),
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
        $model = new Translation;

        if (isset($_POST['Translation'])) {
            $model->attributes = $_POST['Translation'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Translation'])) {
            $model->attributes = $_POST['Translation'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }   

    public function actionIndex() {
        $model = new Translation('search');
        $model->unsetAttributes();
        if (isset($_GET['Translation']))
            $model->attributes = $_GET['Translation'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Translation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'translation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
