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
            array('point', 'numerical', 'max' => 5, 'min' => 1, 'integerOnly' => true),
            array('id, scoring_id, description, point, position', 'safe', 'on' => 'search'),
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
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('point', $this->point, true);
        $criteria->compare('position', $this->position);

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

    public function scopes() {
        return array(
            'last_position' => array(
                'order' => 'position DESC',
            ),
        );
    }

    public function beforeDelete() {
        $models = AnswerDescription::model()->resetScope()->findAllByAttributes(array('scoring_description_id' => $this->id));
        foreach ($models as $key => $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

}
