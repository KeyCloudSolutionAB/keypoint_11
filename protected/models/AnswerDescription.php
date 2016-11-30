<?php

/**
 * This is the model class for table "answer_description".
 *
 * The followings are the available columns in table 'answer_description':
 * @property integer $id
 * @property integer $total_scoring_id
 * @property integer $user_id
 * @property integer $answer
 * @property integer $scoring_description_id
 * @property integer $answer_num
 *
 * The followings are the available model relations:
 * @property ScoringDescription $scoringDescription
 * @property User $user
 * @property TotalScoring $totalScoring
 */
class AnswerDescription extends CActiveRecord {

    public function tableName() {
        return 'answer_description';
    }

    public function rules() {
        return array(
            array('total_scoring_id, scoring_description_id', 'required'),
            array('total_scoring_id, user_id, answer, scoring_description_id, answer_num', 'numerical', 'integerOnly' => true),
            array('id, total_scoring_id, user_id, answer, scoring_description_id, answer_num', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoringDescription' => array(self::BELONGS_TO, 'ScoringDescription', 'scoring_description_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'totalScoring' => array(self::BELONGS_TO, 'TotalScoring', 'total_scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_scoring_id' => Yii::t("translation", "total_scoring_id"),
            'user_id' => Yii::t("translation", "user_id"),
            'answer' => Yii::t("translation", "answer"),
            'scoring_description_id' => Yii::t("translation", "scoring_description_id"),
            'answer_num' => Yii::t("translation", "answer_num"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_scoring_id', $this->total_scoring_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('answer', $this->answer);
        $criteria->compare('scoring_description_id', $this->scoring_description_id);
        $criteria->compare('answer_num', $this->answer_num);

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
            'condition' => "user_id='" . Yii::app()->user->id . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

}
