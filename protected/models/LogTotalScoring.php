<?php

/**
 * This is the model class for table "log_total_scoring".
 *
 * The followings are the available columns in table 'log_total_scoring':
 * @property integer $id
 * @property integer $total_scoring_id
 * @property integer $last_percent
 */
class LogTotalScoring extends CActiveRecord {

    public function tableName() {
        return 'log_total_scoring';
    }

    public function rules() {
        return array(
            array('total_scoring_id, last_percent', 'required'),
            array('total_scoring_id', 'unique'),
            array('total_scoring_id, last_percent', 'numerical', 'integerOnly' => true),
            array('id, total_scoring_id, last_percent', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_scoring_id' => Yii::t("translation", "total_scoring_id"),
            'last_percent' => Yii::t("translation", "last_percent"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_scoring_id', $this->total_scoring_id);
        $criteria->compare('last_percent', $this->last_percent);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function logSave($total_scoring_id, $last_percent) {
        $model = self::model()->findByAttributes(array('total_scoring_id' => $total_scoring_id));
        if (!empty($model)) {
            $model->last_percent = $last_percent;
            $model->save();
        } else {
            $model = new self;
            $model->total_scoring_id = $total_scoring_id;
            $model->last_percent = $last_percent;
            $model->save();
        }
    }

}
