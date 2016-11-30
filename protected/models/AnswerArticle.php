<?php

/**
 * This is the model class for table "answer_article".
 *
 * The followings are the available columns in table 'answer_article':
 * @property integer $id
 * @property integer $total_scoring_id
 * @property integer $user_id
 * @property integer $answer
 * @property integer $article_point_id
 * @property integer $answer_num
 *
 * The followings are the available model relations:
 * @property ArticlePoint $articlePoint
 * @property TotalScoring $totalScoring
 * @property User $user
 */
class AnswerArticle extends CActiveRecord {

    public function tableName() {
        return 'answer_article';
    }

    public function rules() {
        return array(
            array('total_scoring_id, article_point_id, answer', 'required'),
            array('total_scoring_id, user_id, answer, article_point_id, answer_num', 'numerical', 'integerOnly' => true),
            array('id, total_scoring_id, user_id, answer, article_point_id, answer_num', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'articlePoint' => array(self::BELONGS_TO, 'ArticlePoint', 'article_point_id'),
            'totalScoring' => array(self::BELONGS_TO, 'TotalScoring', 'total_scoring_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'total_scoring_id' => Yii::t("translation", "total_scoring"),
            'user_id' => Yii::t("translation", "user"),
            'answer' => Yii::t("translation", "answer"),
            'article_point_id' => Yii::t("translation", "article_point"),
            'answer_num' => Yii::t("translation", "answer_num"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_scoring_id', $this->total_scoring_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('answer', $this->answer);
        $criteria->compare('article_point_id', $this->article_point_id);
        $criteria->compare('answer_num', $this->answer_num);

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
            'condition' => "user_id='" . Yii::app()->user->id . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

}
