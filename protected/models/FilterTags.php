<?php

/**
 * This is the model class for table "filter_tags".
 *
 * The followings are the available columns in table 'filter_tags':
 * @property integer $id
 * @property integer $tag_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Tag $tag
 * @property User $user
 */
class FilterTags extends CActiveRecord {

    public function tableName() {
        return 'filter_tags';
    }

    public function rules() {
        return array(
            array('tag_id, user_id', 'required'),
            array('tag_id, user_id', 'numerical', 'integerOnly' => true),
            array('id, tag_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tag_id' => 'Tag',
            'user_id' => 'User',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('tag_id', $this->tag_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTags() {
        $models = Tag::model()->findAll();
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function checkTags($user_id) {
        $models = self::model()->findAllByAttributes(array('user_id' => $user_id));
        $list = CHtml::listData($models, 'tag_id', 'tag_id');
        return $list;
    }

}
