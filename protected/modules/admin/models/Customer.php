<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $role
 * @property integer $status
 * @property string $create_time
 * @property string $name
 * @property string $contact_name
 * @property string $phone
 * @property string $note
 * @property string $date_entry
 * @property string $registration_code
 * @property string $recover_password
 * @property integer $team_id
 * @property integer $who_created
 * @property string $lang
 *
 * The followings are the available model relations:
 * @property AnswerDescription[] $answerDescriptions
 * @property AnswerNote[] $answerNotes
 * @property AnswerUpload[] $answerUploads
 * @property Comment[] $comments
 * @property FilterCategory[] $filterCategories
 * @property FilterScorlist[] $filterScorlists
 * @property FilterTags[] $filterTags
 * @property Scoring[] $scorings
 * @property Store[] $stores
 * @property StoreCategory[] $storeCategories
 * @property Tag[] $tags
 * @property Team[] $teams
 * @property Team[] $teams1
 * @property TeamName[] $teamNames
 */
class Customer extends CActiveRecord {

    public function tableName() {
        return 'user';
    }

    public function rules() {
        return array(
            array('password', 'required', 'on' => 'new_password'),
            array('email, password, name, contact_name, phone, status', 'required', 'on' => 'customer'),
            array('email, password', 'required'),
            array('email', 'unique'),
            array('email', 'email'),
            array('status, team_id', 'numerical', 'integerOnly' => true),
            array('phone', 'numerical'),
            //
            array('email, password', 'required'),
            array('status, team_id, who_created', 'numerical', 'integerOnly' => true),
            array('email, password, role, name, contact_name, phone, note, registration_code, recover_password', 'length', 'max' => 255),
            array('lang', 'length', 'max' => 2),
            array('date_entry', 'safe'),
            array('id, email, password, role, status, create_time, name, contact_name, phone, note, date_entry, registration_code, recover_password, team_id, who_created, lang', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'adminChooses' => array(self::HAS_MANY, 'AdminChoose', 'user_id'),
            'adminChooses1' => array(self::HAS_MANY, 'AdminChoose', 'customer_id'),
            'answerDescriptions' => array(self::HAS_MANY, 'AnswerDescription', 'user_id'),
            'answerNotes' => array(self::HAS_MANY, 'AnswerNote', 'user_id'),
            'answerUploads' => array(self::HAS_MANY, 'AnswerUpload', 'user_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
            'filterCategories' => array(self::HAS_MANY, 'FilterCategory', 'user_id'),
            'filterScorlists' => array(self::HAS_MANY, 'FilterScorlist', 'user_id'),
            'filterTags' => array(self::HAS_MANY, 'FilterTags', 'user_id'),
            'scorings' => array(self::HAS_MANY, 'Scoring', 'user_id'),
            'scoringSellers' => array(self::HAS_MANY, 'ScoringSeller', 'user_id'),
            'stores' => array(self::HAS_MANY, 'Store', 'user_id'),
            'storeCategories' => array(self::HAS_MANY, 'StoreCategory', 'user_id'),
            'storeSellers' => array(self::HAS_MANY, 'StoreSeller', 'user_id'),
            'tags' => array(self::HAS_MANY, 'Tag', 'user_id'),
            'teams' => array(self::HAS_MANY, 'Team', 'user_id'),
            'teams1' => array(self::HAS_MANY, 'Team', 'who_created'),
            'teamNames' => array(self::HAS_MANY, 'TeamName', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'email' => Yii::t("translation", "contact_email"),
            'password' => Yii::t("translation", "password"),
            'role' => Yii::t("translation", "role"),
            'status' => Yii::t("translation", "status"),
            'create_time' => Yii::t("translation", "create_time"),
            'name' => Yii::t("translation", "customer_name"),
            'contact_name' => Yii::t("translation", "contact_name"),
            'phone' => Yii::t("translation", "phone"),
            'note' => Yii::t("translation", "note"),
            'date_entry' => Yii::t("translation", "date_entry"),
            'registration_code' => Yii::t("translation", "registration_code"),
            'recover_password' => Yii::t("translation", "recover_password"),
            'team_id' => Yii::t("translation", "team_id"),
            'who_created' => Yii::t("translation", "who_created"),
            'lang' => Yii::t("translation", "lang"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('role', 'customer', true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('date_entry', $this->date_entry, true);
        $criteria->compare('registration_code', $this->registration_code, true);
        $criteria->compare('recover_password', $this->recover_password, true);
        $criteria->compare('team_id', $this->team_id);
        $criteria->compare('who_created', $this->who_created);
        $criteria->compare('lang', $this->lang, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //


    public function beforeDelete() {
        $model = Team::model()->findByAttributes(array('user_id' => $this->id));
        if (!empty($model)) {
            throw new CHttpException(700, Yii::t("translation", "you_need_to_delete_the_related_records"));
        }

        $model_admin_choose = AdminChoose::model()->find();
        if ($model_admin_choose->customer_id == $this->id) {
            throw new CHttpException(700, Yii::t("translation", "you_need_to_change_admin_choose_customer"));
        }

        return parent::beforeDelete();
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
            $password = $this->password;
            $this->password = md5($this->password);
            $this->role = 'customer';
            $this->registration_code = $this->sendMailNewUser($password);
        } else {
            if ($this->scenario == 'password') {
                $this->password = md5($this->password);
            }
            if ($this->scenario == 'new_password') {
                $this->password = md5($this->password);
                $this->recover_password = NULL;
            }
        }

        return parent::beforeSave();
    }

    public function getStatus() {
        return array(
            '-1' => Yii::t("translation", "ban"),
            '0' => Yii::t("translation", "registration"),
            '1' => Yii::t("translation", "active"),
            '2' => Yii::t("translation", "password_recovery"),
        );
    }

    public function setStatus($id) {
        $list = array(
            '-1' => Yii::t("translation", "ban"),
            '0' => Yii::t("translation", "registration"),
            '1' => Yii::t("translation", "active"),
            '2' => Yii::t("translation", "password_recovery"),
        );
        return $list[$id];
    }

    public function getTeamId() {
        $models = TeamName::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function setTeamId($id) {
        $model = TeamName::model()->findByPk($id);
        if (empty($model)) {
            throw new CHttpException(404, 'System Error');
        }
        return $model->title;
    }

    // Отправка сообщения recover_password
    public function getRecoverPassword() {
        $this->recover_password = md5(uniqid());

        $restore_password = Yii::app()->createAbsoluteUrl('/login/recover_password', array('url_recover_password' => $this->recover_password));
        $this->saveAttributes(array('recover_password'));
        //
        $bool = FALSE;
        $mail = new YiiMailer();
        $mail->setView('restore_password');
        $mail->setData(array('getname' => $this->name, 'restore_password' => $restore_password));
        //
        $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
        $mail->setSubject(Yii::t("translation", "you_new_password"));
        $mail->setTo(array($this->email => $this->name));
        $mail->setReplyTo(Yii::app()->params['adminEmail']);

        if ($mail->send()) {
            $bool = TRUE;
        }

        return $bool;
    }

    // Отправка сообщения new_user
    public function sendMailNewUser($password) {
        $registration_code_md5 = md5(uniqid());

        $this->registration_code = $registration_code_md5;

        $url_link = Yii::app()->request->hostInfo . '/' . $this->lang . '/login/registration?registration_code=' . $this->registration_code;

//        $registration_code = Yii::app()->createAbsoluteUrl('/' . $this->lang . '/login/registration', array('registration_code' => $this->registration_code));
        $registration_code = $url_link;
        //       
        $mail = new YiiMailer();
        $mail->setView('new_user');
        $mail->setData(
                array(
                    'getname' => $this->name,
                    'registration_code' => $registration_code,
                    'email' => $this->email,
                    'password' => $password,
                )
        );
        //
        $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
        $mail->setSubject(Yii::t("translation", "you_new_password"));
        $mail->setTo(array($this->email => $this->name));
        $mail->setReplyTo(Yii::app()->params['adminEmail']);
        $mail->send();
        return $registration_code_md5;
    }

    // Отправка сообщения уже существующему ползователю
    public function sendMailNewPassword() {
        $password = $this->generatePassword();
        $this->password = md5($password);

        $registration_code_md5 = md5(uniqid());

        $this->registration_code = $registration_code_md5;

        $registration_code = Yii::app()->createAbsoluteUrl('/login/registration', array('registration_code' => $this->registration_code));

        //       
        $mail = new YiiMailer();
        $mail->setView('new_user');
        $mail->setData(
                array(
                    'getname' => $this->name,
                    'registration_code' => $registration_code,
                    'email' => $this->email,
                    'password' => $password,
                )
        );
        //
        $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
        $mail->setSubject(Yii::t("translation", "you_new_password"));
        $mail->setTo(array($this->email => $this->name));
        $mail->setReplyTo(Yii::app()->params['adminEmail']);
        if ($this->saveAttributes(array('registration_code', 'password'))) {
            $mail->send();
        }

        return TRUE;
    }

    // Отправка сообщения уже существующему ползователю + Активному
    public function sendMailNewPassword2() {
        $password = $this->generatePassword();
        $this->password = md5($password);

        $registration_code = Yii::app()->createAbsoluteUrl('/login/index');

        //       
        $mail = new YiiMailer();
        $mail->setView('new_password');
        $mail->setData(
                array(
                    'getname' => $this->name,
                    'registration_code' => $registration_code,
                    'email' => $this->email,
                    'password' => $password,
                )
        );
        //
        $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
        $mail->setSubject(Yii::t("translation", "you_new_password"));
        $mail->setTo(array($this->email => $this->name));
        $mail->setReplyTo(Yii::app()->params['adminEmail']);
        if ($this->saveAttributes(array('password'))) {
            $mail->send();
        }

        return TRUE;
    }

    public function generatePassword($length = 6) {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public function getRole() {
        return array(
            'administrator' => Yii::t("translation", "administrator"),
            'customer' => Yii::t("translation", "customer"),
            'seller' => Yii::t("translation", "seller"),
            'user' => Yii::t("translation", "user"),
        );
    }

    public function setRole($id) {
        $list = array(
            'administrator' => Yii::t("translation", "administrator"),
            'customer' => Yii::t("translation", "customer"),
            'seller' => Yii::t("translation", "seller"),
            'user' => Yii::t("translation", "user"),
        );
        return $list[$id];
    }

    public function getLang() {
        return array(
            'en' => 'en',
            'sv' => 'sv',
            'no' => 'no',
            'da' => 'da',
            'fi' => 'fi',
            'de' => 'de',
        );
    }

    public function setLang($lang) {
        $list = array(
            'en' => 'en',
            'sv' => 'sv',
            'no' => 'no',
            'da' => 'da',
            'fi' => 'fi',
            'de' => 'de',
        );
        return $list[$lang];
    }

    // Получим всех Sellers
    public function getAllSellers() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'who_created = :WhoCreated';
        $criteria->limit = '10';
        $criteria->params = array(':WhoCreated' => Yii::app()->params['choose_customer']);
        $models = self::model()->findAll($criteria);
        return $models;
    }

}
