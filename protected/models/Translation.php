<?php

/**
 * This is the model class for table "translation".
 *
 * The followings are the available columns in table 'translation':
 * @property integer $id
 * @property string $title
 * @property string $translation_en
 * @property string $translation_sv
 * @property string $translation_no
 * @property string $translation_da
 * @property string $translation_fi
 * @property string $translation_de
 */
class Translation extends CActiveRecord {

    public function tableName() {
        return 'translation';
    }

    public function rules() {
        return array(
            array('title, translation_en', 'required'),
            array('title', 'unique'),
            array('title, translation_en, translation_sv, translation_no, translation_da, translation_fi, translation_de', 'length', 'max' => 255),
            array('id, title, translation_en, translation_sv, translation_no, translation_da, translation_fi, translation_de', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => Yii::t("translation", "title"),
            'translation_en' => Yii::t("translation", "translation_en"),
            'translation_sv' => Yii::t("translation", "translation_sv"),
            'translation_no' => Yii::t("translation", "translation_no"),
            'translation_da' => Yii::t("translation", "translation_da"),
            'translation_fi' => Yii::t("translation", "translation_fi"),
            'translation_de' => Yii::t("translation", "translation_de"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('translation_en', $this->translation_en, true);
        $criteria->compare('translation_sv', $this->translation_sv, true);
        $criteria->compare('translation_no', $this->translation_no, true);
        $criteria->compare('translation_da', $this->translation_da, true);
        $criteria->compare('translation_fi', $this->translation_fi, true);
        $criteria->compare('translation_de', $this->translation_de, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,           
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function defaultScope() {
        return array(
            'order' => 'id DESC',
        );
    }

}
