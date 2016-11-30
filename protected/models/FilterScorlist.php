<?php

/**
 * This is the model class for table "filter_scorlist".
 *
 * The followings are the available columns in table 'filter_scorlist':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 * @property User $user
 */
class FilterScorlist extends CActiveRecord {

    public function tableName() {
        return 'filter_scorlist';
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
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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

    public function getScorings() {
        $models = Scoring::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function checkScorings($user_id) {
        $models = self::model()->findAllByAttributes(array('user_id' => $user_id));
        $list = CHtml::listData($models, 'scoring_id', 'scoring_id');
        return $list;
    }

}
