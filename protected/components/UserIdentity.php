<?php

class UserIdentity extends CUserIdentity {

    const ERROR_STATUS_INVALID_0 = 3;

    // Будем хранить id.
    protected $_id;

    // Данный метод вызывается один раз при аутентификации пользователя.
    public function authenticate() {
        // Производим стандартную аутентификацию, описанную в руководстве.
        $user = User::model()->find('LOWER(email)=?', array(strtolower($this->username)));
        if (($user === null) || (md5($this->password) !== $user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->status == 1) {
                $this->_id = $user->id;
                $this->username = $user->name;
                //
                if (!empty($user->registration_code)) {
                    $user->registration_code = NULL;
                    $user->saveAttributes(array('registration_code'));
                }
                if (!empty($user->recover_password)) {
                    $user->recover_password = NULL;
                    $user->saveAttributes(array('recover_password'));
                }
                //
                $user->date_entry = new CDbExpression('NOW()');
                $user->saveAttributes(array('date_entry'));
                $this->errorCode = self::ERROR_NONE;
            } else {
                switch ($user->status) {
                    case 0:
                        $this->errorCode = self::ERROR_STATUS_INVALID_0;
                        break;

                    default:
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                        break;
                }
            }
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
