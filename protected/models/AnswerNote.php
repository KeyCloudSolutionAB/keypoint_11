<?php

/**
 * This is the model class for table "answer_note".
 *
 * The followings are the available columns in table 'answer_note':
 * @property integer $id
 * @property integer $total_scoring_id
 * @property integer $user_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property TotalScoring $totalScoring
 * @property User $user
 */
class AnswerNote extends CActiveRecord {

    public function tableName() {
        return 'answer_note';
    }

    public function rules() {
        return array(
            array('total_scoring_id, note', 'required'),
            array('total_scoring_id, user_id', 'numerical', 'integerOnly' => true),
            array('note', 'length', 'max' => 255),
            array('id, total_scoring_id, user_id, note', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'totalScoring' => array(self::BELONGS_TO, 'TotalScoring', 'total_scoring_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_scoring_id' => Yii::t("translation", "total_scoring_id"),
            'user_id' => Yii::t("translation", "user_id"),
            'note' => Yii::t("translation", "note"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_scoring_id', $this->total_scoring_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('note', $this->note, true);

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
