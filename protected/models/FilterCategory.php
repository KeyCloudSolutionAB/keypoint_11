<?php

/**
 * This is the model class for table "filter_category".
 *
 * The followings are the available columns in table 'filter_category':
 * @property integer $id
 * @property integer $store_category_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property StoreCategory $storeCategory
 * @property User $user
 */
class FilterCategory extends CActiveRecord {

    public function tableName() {
        return 'filter_category';
    }

    public function rules() {
        return array(
            array('store_category_id, user_id', 'required'),
            array('store_category_id, user_id', 'numerical', 'integerOnly' => true),
            array('id, store_category_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'storeCategory' => array(self::BELONGS_TO, 'StoreCategory', 'store_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_category_id' => 'Store Category',
            'user_id' => 'User',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('store_category_id', $this->store_category_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCategories() {
        $models = StoreCategory::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function checkCategories($user_id) {
        $models = self::model()->findAllByAttributes(array('user_id' => $user_id));
        $list = CHtml::listData($models, 'store_category_id', 'store_category_id');
        return $list;
    }

}
