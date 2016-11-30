<?php

/**
 * This is the model class for table "scoring_seller".
 *
 * The followings are the available columns in table 'scoring_seller':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Scoring $scoring
 */
class ScoringSeller extends CActiveRecord {

    public function tableName() {
        return 'scoring_seller';
    }

    public function rules() {
        return array(
            array('scoring_id, user_id', 'required'),
            array('scoring_id, user_id', 'numerical', 'integerOnly' => true),
            array('id, scoring_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => 'Scoring',
            'user_id' => 'User',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
