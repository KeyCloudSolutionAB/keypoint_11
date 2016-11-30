<?php

/**
 * This is the model class for table "scoring_category".
 *
 * The followings are the available columns in table 'scoring_category':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $store_category_id
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 * @property StoreCategory $storeCategory
 */
class ScoringCategory extends CActiveRecord {

    public function tableName() {
        return 'scoring_category';
    }

    public function rules() {
        return array(
            array('scoring_id, store_category_id', 'required'),
            array('scoring_id, store_category_id', 'numerical', 'integerOnly' => true),
            array('id, scoring_id, store_category_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
            'storeCategory' => array(self::BELONGS_TO, 'StoreCategory', 'store_category_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => 'Scoring',
            'store_category_id' => 'Store Category',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('store_category_id', $this->store_category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
