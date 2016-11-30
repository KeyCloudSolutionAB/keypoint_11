<?php

class AddStoreTagForm extends CFormModel {

    public $store_category;
    public $tags;
    public $scoring_id;

    public function rules() {
        return array(
            array('scoring_id', 'numerical', 'integerOnly' => true),
            array('store_category, tags', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'store_category' => Yii::t("translation", "store_category"),
            'tags' => Yii::t("translation", "tags"),
            'scoring_id' => Yii::t("translation", "scoring_id"),
        );
    }

    public function getStoreCategory() {
        $models = StoreCategory::model()->findAll();
        $array = array();
        foreach ($models as $key => $value) {
            $all_stores = Store::model()->findAllByAttributes(array('store_category_id' => $value->id));
            $count = count($all_stores);
            $array[$value->id] = $value->Name . ' (' . $count . ' ' . Yii::t("translation", "stores_count") . ')';
        }
        return $array;
    }

    public function getTags() {
        $models = Tag::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

}
