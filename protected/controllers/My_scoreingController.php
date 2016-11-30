<?php

class My_scoreingController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'missing_store', 'all_images', 'one_image'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->redirect(array('site/index'));
    }

    public function actionView($id) {
        $id = (int) $id;
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        //



        $this->render('view', array('model' => $model));
    }

    public function actionMissing_store($id) {
        $id = (int) $id;
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        //


        $this->render('missing_store', array('model' => $model));
    }

    public function actionAll_images($id) {
        $id = (int) $id;
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        //

        $images = $model->AnswerUpload;


        $this->render('all_images', array('model' => $model, 'images' => $images));
    }

    public function actionOne_image($id, $image_id) {
        $id = (int) $id;
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        //

        $image = AnswerUpload::model()->findByPk($image_id);


        $this->render('one_image', array('model' => $model, 'image' => $image));
    }

}
