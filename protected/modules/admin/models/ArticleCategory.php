<?php

/**
 * This is the model class for table "article_category".
 *
 * The followings are the available columns in table 'article_category':
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 * @property User $user
 */
class ArticleCategory extends CActiveRecord {

    public function tableName() {
        return 'article_category';
    }

    public function rules() {
        return array(
            array('title', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('id, title, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'articles' => array(self::HAS_MANY, 'Article', 'article_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t("translation", "id"),
            'title' => Yii::t("translation", "title"),
            'user_id' => Yii::t("translation", "user"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('user_id', $this->user_id);

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

    protected function beforeDelete() {
        $models = Article::model()->resetScope()->findAllByAttributes(array('article_category_id' => $this->id));
        foreach ($models as $key => $value) {
            $value->delete();
        }       

        return parent::beforeDelete();
    }

}
