<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'contact', 'logout', 'top'),
                'roles' => array('seller'),
            ),
            array('allow',
                'actions' => array('captcha'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function actionIndex() {
        $seller_all_scoring = ScoringSeller::model()->findAll();
        $my_all_scoreing = array();
        $total_scoring = array();
        foreach ($seller_all_scoring as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id = :scoringID AND status = 0';
            $criteria->params = array(':scoringID' => $value->scoring_id);
            $model = Scoring::model()->find($criteria);
            if (!empty($model)) {
                $my_all_scoreing[$model->title] = $model;
            }
        }
        ksort($my_all_scoreing);      
        $this->render('index', array('my_all_scoreing' => $my_all_scoreing));
    }

    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionTop($id = NULL) {
        $model_user = User::model()->resetScope()->findByPk(Yii::app()->user->id);

        if (!empty($id)) {
            $model = $this->loadModel($id);
            if (!empty($model->id)) {
                $models = TotalScoring::model()->getShareTopSellers($model_user->who_created, $model->id);
            } else {
                $models = TotalScoring::model()->getShareTopSellers($model_user->who_created);
            }
        } else {
            $model = NULL;
            $models = TotalScoring::model()->getShareTopSellers($model_user->who_created);
        }

        $this->render('top', array('model' => $model, 'models' => $models));
    }

    public function loadModel($id) {
        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
