<?php

/**
 * This is the model class for table "scoring_description".
 *
 * The followings are the available columns in table 'scoring_description':
 * @property integer $id
 * @property integer $scoring_id
 * @property string $description
 * @property string $point
 * @property integer $position
 * @property integer $num 
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 */
class ScoringDescription extends CActiveRecord {

    public function tableName() {
        return 'scoring_description';
    }

    public function rules() {
        return array(
            array('scoring_id, description, point', 'required'),
            array('scoring_id, position', 'numerical', 'integerOnly' => true),
            array('description', 'length', 'max' => 255),
            array('point, num', 'numerical', 'max' => 1),
            array('id, scoring_id, description, point, position, num', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'answerDescriptions' => array(self::HAS_MANY, 'AnswerDescription', 'scoring_description_id'),
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => Yii::t("translation", "scoring_id"),
            'description' => Yii::t("translation", "description"),
            'point' => Yii::t("translation", "point"),
            'position' => Yii::t("translation", "position"),
            'num' => Yii::t("translation", "num"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('point', $this->point, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('num', $this->num);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //
    public function defaultScope() {
        return array(
            'order' => 'position ASC',
        );
    }

}
