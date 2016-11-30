<?php

/**
 * This is the model class for table "store_tag".
 *
 * The followings are the available columns in table 'store_tag':
 * @property integer $id
 * @property integer $store_id
 * @property integer $tag_id
 *
 * The followings are the available model relations:
 * @property Store $store
 * @property Tag $tag
 */
class StoreTag extends CActiveRecord {

    public function tableName() {
        return 'store_tag';
    }

    public function rules() {
        return array(
            array('store_id, tag_id', 'required'),
            array('store_id, tag_id', 'numerical', 'integerOnly' => true),
            array('id, store_id, tag_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_id' => Yii::t("translation", "store_id"),
            'tag_id' => Yii::t("translation", "tag_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('tag_id', $this->tag_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
