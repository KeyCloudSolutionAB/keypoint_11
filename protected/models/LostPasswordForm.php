<?php

class LostPasswordForm extends CFormModel {

    public $email;
    public $verifyCode;

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    public function attributeLabels() {
        return array(
            'verifyCode' => Yii::t("translation", "verification_code"),
        );
    }

}
