<?php

/**
 * This is the model class for table "team".
 *
 * The followings are the available columns in table 'team':
 * @property integer $id
 * @property integer $user_id
 * @property integer $team_name_id
 * @property integer $who_created
 *
 * The followings are the available model relations:
 * @property TeamName $teamName
 * @property User $user
 * @property User $whoCreated
 */
class Team extends CActiveRecord {

    public function tableName() {
        return 'team';
    }

    public function rules() {
        return array(
            array('user_id, team_name_id', 'required'),
            array('user_id, team_name_id, who_created', 'numerical', 'integerOnly' => true),
            array('id, user_id, team_name_id, who_created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'teamName' => array(self::BELONGS_TO, 'TeamName', 'team_name_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'whoCreated' => array(self::BELONGS_TO, 'User', 'who_created'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t("translation", "user_id"),
            'team_name_id' => Yii::t("translation", "team_name_id"),
            'who_created' => Yii::t("translation", "who_created"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('team_name_id', $this->team_name_id);
        $criteria->compare('who_created', Yii::app()->params['choose_customer']);

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
            'condition' => "who_created='" . Yii::app()->params['choose_customer'] . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->who_created = Yii::app()->params['choose_customer'];
        }

        return parent::beforeSave();
    }

    public function getAllStore() {
        $models = StoreSeller::model()->findAllByAttributes(array('user_id' => $this->user_id));

        return count($models);
    }

    public function getAllStoreFilters($scoring_id) {
        // 1
        $scoring_cat_all = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $scoring_id));
        $list_scoring_cat_all = CHtml::listData($scoring_cat_all, 'id', 'store_category_id');

        // 2
        $store_seller_all = StoreSeller::model()->findAllByAttributes(array('user_id' => $this->user_id));
        $list_store_seller_all = CHtml::listData($store_seller_all, 'store_id', 'store_id');

        //3
        $array = array();
        foreach ($list_scoring_cat_all as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'store_category_id = :storeCategoryId';
            $criteria->params = array(':storeCategoryId' => $value);
            $criteria->select = 'id, store_category_id';
            $models = Store::model()->findAll($criteria);
            $list = CHtml::listData($models, 'id', 'id');

            foreach ($list as $key => $value) {
                if (isset($list_store_seller_all[$value])) {
                    $array[] = $value;
                }
            }
        }

        return count($array);
    }

}
