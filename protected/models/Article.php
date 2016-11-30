<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $id
 * @property integer $article_category_id
 * @property integer $user_id
 * @property string $title
 * @property integer $article_id
 * @property integer $cpg
 * @property string $ean
 *
 * The followings are the available model relations:
 * @property ArtCat[] $artCats
 * @property ArticleCategory $articleCategory
 * @property User $user
 * @property ArticlePoint[] $articlePoints
 */
class Article extends CActiveRecord {

    public function tableName() {
        return 'article';
    }

    public function rules() {
        return array(
            array('article_category_id, user_id, title', 'required'),
            array('article_category_id, user_id, article_id, cpg', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('ean', 'length', 'max' => 20),
            array('id, article_category_id, user_id, title, article_id, cpg, ean', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'artCats' => array(self::HAS_MANY, 'ArtCat', 'article_id'),
            'articleCategory' => array(self::BELONGS_TO, 'ArticleCategory', 'article_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'articlePoints' => array(self::HAS_MANY, 'ArticlePoint', 'article_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'article_category_id' => Yii::t("translation", "article_category"),
            'user_id' => Yii::t("translation", "user"),
            'title' => Yii::t("translation", "title"),
            'article_id' => Yii::t("translation", "article"),
            'cpg' => Yii::t("translation", "cpg"),
            'ean' => Yii::t("translation", "ean"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('article_category_id', $this->article_category_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('article_id', $this->article_id);
        $criteria->compare('cpg', $this->cpg);
        $criteria->compare('ean', $this->ean, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
