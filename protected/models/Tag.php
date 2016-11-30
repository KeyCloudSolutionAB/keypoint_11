<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $title
 * @property string $lang
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property FilterTags[] $filterTags
 * @property ScoringTag[] $scoringTags
 * @property StoreTag[] $storeTags
 * @property User $user
 */
class Tag extends CActiveRecord {

    public function tableName() {
        return 'tag';
    }

    public function rules() {
        return array(
            array('title', 'unique'),
            //
            array('title', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('lang', 'length', 'max' => 2),
            array('id, title, lang, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'filterTags' => array(self::HAS_MANY, 'FilterTags', 'tag_id'),
            'scoringTags' => array(self::HAS_MANY, 'ScoringTag', 'tag_id'),
            'storeTags' => array(self::HAS_MANY, 'StoreTag', 'tag_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => Yii::t("translation", "title"),
            'lang' => Yii::t("translation", "lang"),
            'user_id' => Yii::t("translation", "user_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function getLang() {
        return array(
            'en' => 'en',
            'sv' => 'sv',
            'no' => 'no',
            'da' => 'da',
            'fi' => 'fi',
            'de' => 'de',
        );
    }

}
