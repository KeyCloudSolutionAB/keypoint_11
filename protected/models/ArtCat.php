<?php

/**
 * This is the model class for table "art_cat".
 *
 * The followings are the available columns in table 'art_cat':
 * @property integer $id
 * @property integer $user_id
 * @property integer $article_id
 * @property integer $store_category_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Article $article
 * @property StoreCategory $storeCategory
 * @property User $user
 */
class ArtCat extends CActiveRecord {

    public function tableName() {
        return 'art_cat';
    }

    public function rules() {
        return array(
            array('user_id, article_id, store_category_id', 'required'),
            array('user_id, article_id, store_category_id', 'numerical', 'integerOnly' => true),
            array('value', 'length', 'max' => 5),
            array('id, user_id, article_id, store_category_id, value', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
            'storeCategory' => array(self::BELONGS_TO, 'StoreCategory', 'store_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'user_id' => Yii::t("translation", "user"),
            'article_id' => Yii::t("translation", "article"),
            'store_category_id' => Yii::t("translation", "store_category"),
            'value' => Yii::t("translation", "value"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('article_id', $this->article_id);
        $criteria->compare('store_category_id', $this->store_category_id);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ****************************
    
    public function getScoringCats($store_category_id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'store_category_id = :StoreCategoryID';
        $criteria->params = array(':StoreCategoryID' => $store_category_id);
        $criteria->select = 'scoring_id';
        $models = ScoringCategory::model()->findAll($criteria);
        $array = NULL;
        foreach ($models as $key => $value) {
            $array[$value->scoring_id] = $value->scoring_id;
        }
        return $array;
    }

}
