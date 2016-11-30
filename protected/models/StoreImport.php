<?php

/**
 * This is the model class for table "store_import".
 *
 * The followings are the available columns in table 'store_import':
 * @property integer $id
 * @property string $storename
 * @property string $adress
 * @property string $zip
 * @property string $city
 * @property string $phone
 * @property string $store_category
 * @property string $tag
 * @property string $seller
 * @property string $team
 */
class StoreImport extends CActiveRecord {

    public function tableName() {
        return 'store_import';
    }

    public function rules() {
        return array(
            array('storename, adress, zip, city, phone, store_category, tag, seller, team', 'length', 'max' => 255),
            array('id, storename, adress, zip, city, phone, store_category, tag, seller, team', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'storename' => 'Storename',
            'adress' => 'Adress',
            'zip' => 'Zip',
            'city' => 'City',
            'phone' => 'Phone',
            'store_category' => 'Store Category',
            'tag' => 'Tag',
            'seller' => 'Seller',
            'team' => 'Team',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('storename', $this->storename, true);
        $criteria->compare('adress', $this->adress, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('store_category', $this->store_category, true);
        $criteria->compare('tag', $this->tag, true);
        $criteria->compare('seller', $this->seller, true);
        $criteria->compare('team', $this->team, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
