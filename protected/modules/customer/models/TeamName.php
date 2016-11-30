<?php

/**
 * This is the model class for table "team_name".
 *
 * The followings are the available columns in table 'team_name':
 * @property integer $id
 * @property string $title
 * @property string $lang
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ScoringSeller[] $scoringSellers
 * @property Team[] $teams
 * @property User $user
 */
class TeamName extends CActiveRecord {

    public function tableName() {
        return 'team_name';
    }

    public function rules() {
        return array(
            array('title', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('lang', 'length', 'max' => 2),
            array('id, title, lang, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'teams' => array(self::HAS_MANY, 'Team', 'team_name_id'),
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
        $criteria->compare('user_id', Yii::app()->user->id);

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
            $this->lang = Yii::app()->language;
        }

        return parent::beforeSave();
    }

    public function beforeDelete() {
        $model = User::model()->findByAttributes(array('team_id' => $this->id));
        if (!empty($model)) {
            throw new CHttpException(700, Yii::t("translation", "you_need_to_delete_the_related_records"));
        }
        return parent::beforeDelete();
    }

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

    public function setLang($id) {
        $list = array(
            'en' => 'en',
            'sv' => 'sv',
            'no' => 'no',
            'da' => 'da',
            'fi' => 'fi',
            'de' => 'de',
        );
        return $list[$id];
    }

}
