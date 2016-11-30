<?php

/**
 * This is the model class for table "scoring_image_upload".
 *
 * The followings are the available columns in table 'scoring_image_upload':
 * @property integer $id
 * @property integer $scoring_id
 * @property string $description
 * @property string $point
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 */
class ScoringImageUpload extends CActiveRecord {

    public function tableName() {
        return 'scoring_image_upload';
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
            'answerUploads' => array(self::HAS_MANY, 'AnswerUpload', 'scoring_image_upload_id'),
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => 'Scoring',
            'description' => 'Description',
            'point' => 'Point',
            'position' => 'Position',
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
        $models = AnswerUpload::model()->resetScope()->findAllByAttributes(array('scoring_image_upload_id' => $this->id));
        foreach ($models as $key => $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

}
