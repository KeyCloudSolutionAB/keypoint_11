<?php

/**
 * This is the model class for table "article_import".
 *
 * The followings are the available columns in table 'article_import':
 * @property integer $id
 * @property string $article_id
 * @property string $title
 * @property string $cpg
 * @property string $article_category
 * @property string $ean
 */
class ArticleImport extends CActiveRecord {

    public function tableName() {
        return 'article_import';
    }

    public function rules() {
        return array(
            array('article_id, title, cpg, article_category, ean', 'length', 'max' => 255),
            array('id, article_id, title, cpg, article_category, ean', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'article_id' => Yii::t("translation", "article"),
            'title' => Yii::t("translation", "title"),
            'cpg' => Yii::t("translation", "cpg"),
            'article_category' => Yii::t("translation", "article_category"),
            'ean' => Yii::t("translation", "ean"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('article_id', $this->article_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('cpg', $this->cpg, true);
        $criteria->compare('article_category', $this->article_category, true);
        $criteria->compare('ean', $this->ean, true);

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
            'order' => 'title ASC',
        );
    }

}
