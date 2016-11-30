<?php

/**
 * This is the model class for table "article_check".
 *
 * The followings are the available columns in table 'article_check':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $article_id
 *
 * The followings are the available model relations:
 * @property Scoring $scoring
 * @property Article $article
 */
class ArticleCheck extends CActiveRecord {

    public function tableName() {
        return 'article_check';
    }

    public function rules() {
        return array(
            array('scoring_id, article_id', 'required'),
            array('scoring_id, article_id', 'numerical', 'integerOnly' => true),
            array('id, scoring_id, article_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
            'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'scoring_id' => Yii::t("translation", "scoring"),
            'article_id' => Yii::t("translation", "article"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('article_id', $this->article_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
