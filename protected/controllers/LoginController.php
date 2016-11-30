<?php

class LoginController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function actionIndex() {
        if (Yii::app()->user->checkAccess('user')) {
            $this->redirect('/');
        }
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                switch (Yii::app()->user->role) {
                    case 'administrator':
                        $model_user = User::model()->resetScope()->findByPk(Yii::app()->user->id);
                        $this->redirect('/' . $model_user->lang . '/admin');                     
                        break;
                    case 'customer':
                        $model_user = User::model()->resetScope()->findByPk(Yii::app()->user->id);
                        $this->redirect('/' . $model_user->lang . '/customer');
                        break;
                    case 'seller':
                        $model_user = User::model()->resetScope()->findByPk(Yii::app()->user->id);
                        $this->redirect('/' . $model_user->lang);
                        break;
                    default:
                        $this->redirect(Yii::app()->user->returnUrl);
                        break;
                }
            }
        }
        $this->renderPartial('index', array('model' => $model));
    }

    public function actionPassword() {
        if (Yii::app()->user->checkAccess('user')) {
            $this->redirect('/');
        }
        $model = new LostPasswordForm;
        if (isset($_POST['LostPasswordForm'])) {
            $model->attributes = $_POST['LostPasswordForm'];
            if ($model->validate()) {
                $model->email = strtolower($model->email);
                $mail = User::model()->findByAttributes(array('email' => $model->email));
                if (!empty($mail)) {
                    $bool = $mail->RecoverPassword;
                    if ($bool) {
                        Yii::app()->user->setFlash('good', Yii::t("translation", "restore_code_has_been_sent"));
                    } else {
                        Yii::app()->user->setFlash('error', Yii::t("translation", "system_error_try_later"));
                    }
                } else {
                    Yii::app()->user->setFlash('error', Yii::t("translation", "this_e_mail_does_not_exist"));
                }
            } else {
                Yii::app()->user->setFlash('error', Yii::t("translation", "the_error_in_filling"));
            }
        }

        $this->renderPartial('password', array('model' => $model));
    }

    public function actionRecover_password($url_recover_password) {
        $url_recover_password = CHtml::encode($url_recover_password);
        if (empty($url_recover_password)) {
            $this->redirect('/');
        }
        $model = User::model()->findByAttributes(array('recover_password' => $url_recover_password));
        if (empty($model)) {
            $this->redirect('/');
        }
        $model->setScenario('new_password');

        if (isset($_POST['User']['password'])) {
            if (!empty($_POST['User']['password'])) {
                $model->password = $_POST['User']['password'];
                if ($model->validate()) {
                    if ($model->save(array('password'))) {
                        Yii::app()->user->setFlash('good', Yii::t("translation", "you_have_successfully_saved_a_new_password"));
                        $this->redirect(array('login/index'));
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', Yii::t("translation", "you_need_to_write_a_new_password"));
            }
        }


        $model->password = NULL;
        $this->renderPartial('new_password', array('model' => $model));
    }

    public function actionRegistration($registration_code) {
        $registration_code = CHtml::encode($registration_code);
        if (empty($registration_code)) {
            $this->redirect('/');
        }
        $model = User::model()->findByAttributes(array('registration_code' => $registration_code));
        if (!empty($model)) {
            $model->status = 1;
            $model->registration_code = NULL;
            $bool = $model->saveAttributes(array('status', 'registration_code'));
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "you_have_successfully_confirmed_your_email"));
                $this->redirect(array('login/index'));
            }
        } else {
            Yii::app()->user->setFlash('error', Yii::t("translation", "this_registration_code_does_not_exist"));
            $this->redirect(array('login/index'));
        }
    }

}
