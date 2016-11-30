<?php

/**
 * This is the model class for table "article_point".
 *
 * The followings are the available columns in table 'article_point':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $article_id
 * @property integer $point
 * @property integer $position
 * @property integer $num
 *
 * The followings are the available model relations:
 * @property AnswerArticle[] $answerArticles
 * @property Article $article
 * @property Scoring $scoring
 */
class ArticlePoint extends CActiveRecord {

    public function tableName() {
        return 'article_point';
    }

    public function rules() {
        return array(
            array('scoring_id, article_id, point', 'required'),
            array('scoring_id, article_id, position, num', 'numerical', 'integerOnly' => true),
            array('point', 'numerical', 'max' => 5, 'min' => 1, 'integerOnly' => true),
            array('id, scoring_id, article_id, point, position, num', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'answerArticles' => array(self::HAS_MANY, 'AnswerArticle', 'article_point_id'),
            'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'scoring_id' => Yii::t("translation", "scoring"),
            'article_id' => Yii::t("translation", "article"),
            'point' => Yii::t("translation", "point"),
            'position' => Yii::t("translation", "position"),
            'num' => Yii::t("translation", "num"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('article_id', $this->article_id);
        $criteria->compare('point', $this->point);
        $criteria->compare('position', $this->position);
        $criteria->compare('num', $this->num);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //
    public function defaultScope() {
        return array(
            'order' => 'position ASC',
        );
    }

    public function scopes() {
        return array(
            'last_position' => array(
                'order' => 'position DESC',
            ),
        );
    }

    public function beforeDelete() {
        $models = AnswerArticle::model()->resetScope()->findAllByAttributes(array('article_point_id' => $this->id));
        foreach ($models as $key => $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

}
