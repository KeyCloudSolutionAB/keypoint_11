<?php

/**
 * This is the model class for table "scoring_image".
 *
 * The followings are the available columns in table 'scoring_image':
 * @property integer $id
 * @property integer $scoring_id
 * @property string $title
 * @property string $image
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 */
class ScoringImage extends CActiveRecord {

    public function tableName() {
        return 'scoring_image';
    }

    public function rules() {
        return array(
            array('scoring_id', 'required'),
            array('scoring_id, position', 'numerical', 'integerOnly' => true),
            array('title, image', 'length', 'max' => 255),
            array('id, scoring_id, title, image, create_time, position', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => Yii::t("translation", "scoring_id"),
            'title' => Yii::t("translation", "title"),
            'image' => Yii::t("translation", "image"),
            'create_time' => Yii::t("translation", "create_time"),
            'position' => Yii::t("translation", "position"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('create_time', $this->create_time, true);
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
            'order' => 'position DESC',
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
            $model = self::model()->findByAttributes(array('scoring_id' => $this->scoring_id));
            if (!empty($model)) {
                $position = $model->position + 1;
                $this->position = $position;
            } else {
                $this->position = 0;
            }
        }

        return parent::beforeSave();
    }

    public function behaviors() {
        return array(
            'uploadableFile' => array(
                'class' => 'application.components.UploadableFileBehavior',
                'savePathAlias' => 'webroot.upload_files.scoring_image',
            ),
        );
    }

}
