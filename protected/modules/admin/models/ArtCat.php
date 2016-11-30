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
            array('article_id, store_category_id, value', 'required'),
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

    // ============================== //

    public function defaultScope() {
        return array(
            'condition' => "user_id='" . Yii::app()->params['choose_customer'] . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->params['choose_customer'];
        }

        return parent::beforeSave();
    }

    public function getArticleName() {
        $model = Article::model()->findByPk($this->article_id);
        if (!empty($model)) {
            return $model->title;
        } else {
            return '-';
        }
    }

    public function getAllArticle() {
        $models = Article::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function getStoreCategoryName() {
        $model = StoreCategory::model()->findByPk($this->store_category_id);
        if (!empty($model)) {
            return $model->title;
        } else {
            return '-';
        }
    }

    public function getAllStoreCategory() {
        $models = StoreCategory::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    protected function beforeDelete() {
        $models = ArticlePoint::model()->resetScope()->findAllByAttributes(array('article_id' => $this->article_id));
        foreach ($models as $key => $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

}
