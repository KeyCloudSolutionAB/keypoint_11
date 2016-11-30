<?php

/**
 * This is the model class for table "scoring_tag".
 *
 * The followings are the available columns in table 'scoring_tag':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $tag_id
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 * @property Tag $tag
 */
class ScoringTag extends CActiveRecord {

    public function tableName() {
        return 'scoring_tag';
    }

    public function rules() {
        return array(
            array('scoring_id, tag_id', 'required'),
            array('scoring_id, tag_id', 'numerical', 'integerOnly' => true),
            array('id, scoring_id, tag_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
            'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => 'Scoring',
            'tag_id' => 'Tag',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('tag_id', $this->tag_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
