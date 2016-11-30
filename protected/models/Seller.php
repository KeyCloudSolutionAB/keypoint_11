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
class Seller extends CActiveRecord {

    public function tableName() {
        return 'user';
    }

    public function rules() {
        return array(
            array('password', 'required', 'on' => 'new_password'),
            array('email, password, name, phone, status', 'required', 'on' => 'seller'),
            array('email, password, name, phone, status', 'required', 'on' => 'import_seller'),
            array('email', 'email'),
            array('email, password', 'required'),
            array('email', 'unique', 'on' => 'seller'),
            array('email', 'checkUnique', 'on' => 'seller'),
            array('status, team_id', 'numerical', 'integerOnly' => true),
            array('phone', 'numerical'),
            //         
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
            'name' => Yii::t("translation", "seller_name"),
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
        $criteria->compare('role', 'seller', true);
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
        $criteria->compare('who_created', Yii::app()->user->id);
        $criteria->compare('lang', $this->lang, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //
}
