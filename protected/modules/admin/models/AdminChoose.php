<?php

/**
 * This is the model class for table "admin_choose".
 *
 * The followings are the available columns in table 'admin_choose':
 * @property integer $id
 * @property integer $user_id
 * @property integer $customer_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $customer
 */
class AdminChoose extends CActiveRecord {

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

    public function tableName() {
        return 'admin_choose';
    }

    public function rules() {
        return array(
            array('customer_id', 'required'),
            array('user_id, customer_id', 'numerical', 'integerOnly' => true),
            array('id, user_id, customer_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'customer' => array(self::BELONGS_TO, 'User', 'customer_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t("translation", "user_id"),
            'customer_id' => Yii::t("translation", "customer_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('customer_id', $this->customer_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //

    public function getCustomers() {
        $models = User::model()->findAllByAttributes(array('role' => 'customer'));
        $list = CHtml::listData($models, 'id', 'name');
        return $list;
    }

}
