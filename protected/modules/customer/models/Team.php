<?php

/**
 * This is the model class for table "team".
 *
 * The followings are the available columns in table 'team':
 * @property integer $id
 * @property integer $user_id
 * @property integer $team_name_id
 * @property integer $who_created
 *
 * The followings are the available model relations:
 * @property TeamName $teamName
 * @property User $user
 * @property User $whoCreated
 */
class Team extends CActiveRecord {

    public function tableName() {
        return 'team';
    }

    public function rules() {
        return array(
            array('user_id, team_name_id', 'required'),
            array('user_id, team_name_id, who_created', 'numerical', 'integerOnly' => true),
            array('id, user_id, team_name_id, who_created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'teamName' => array(self::BELONGS_TO, 'TeamName', 'team_name_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'whoCreated' => array(self::BELONGS_TO, 'User', 'who_created'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t("translation", "user_id"),
            'team_name_id' => Yii::t("translation", "team_name_id"),
            'who_created' => Yii::t("translation", "who_created"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('team_name_id', $this->team_name_id);
        $criteria->compare('who_created', Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function defaultScope() {
        return array(
            'condition' => "who_created='" . Yii::app()->user->id . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->who_created = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

}
