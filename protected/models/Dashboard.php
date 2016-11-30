<?php

/**
 * This is the model class for table "dashboard".
 *
 * The followings are the available columns in table 'dashboard':
 * @property integer $id
 * @property string $date_begin
 * @property string $date_end
 * @property integer $status
 * @property string $title
 * @property integer $user_id
 * @property string $key
 * @property integer $customer_id
 *
 * The followings are the available model relations:
 * @property User $customer
 * @property User $user
 */
class Dashboard extends CActiveRecord {

    public function tableName() {
        return 'dashboard';
    }

    public function rules() {
        return array(
            array('status, user_id, customer_id', 'numerical', 'integerOnly' => true),
            array('title, key', 'length', 'max' => 45),
            array('date_begin, date_end', 'safe'),
            array('id, date_begin, date_end, status, title, user_id, key, customer_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'customer' => array(self::BELONGS_TO, 'User', 'customer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date_begin' => Yii::t("translation", "date_begin"),
            'date_end' => Yii::t("translation", "date_end"),
            'status' => Yii::t("translation", "status"),
            'title' => Yii::t("translation", "title"),
            'user_id' => Yii::t("translation", "user_id"),
            'key' => Yii::t("translation", "key"),
            'customer_id' => Yii::t("translation", "customer_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('date_begin', $this->date_begin, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('customer_id', $this->customer_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function defaultScope() {
        if (Yii::app()->user->isGuest) {
            return array(
                'condition' => "status != 0",
            );
        } else {
            return array(
                'condition' => "user_id='" . Yii::app()->user->id . "'",
            );
        }
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            if (Yii::app()->user->role == "administrator") {
                $this->customer_id = Yii::app()->params['choose_customer'];
            } else {
                $this->customer_id = Yii::app()->user->id;
            }
            $str = 'abc' . uniqid() . 'key';
            $this->key = md5($str);
            $this->status = 1;
            if (empty($this->title)) {
                $this->title = $this->key;
            }
        }


        return parent::beforeSave();
    }

    public function getStatus() {
        return array(
            '-1' => Yii::t("translation", "ban"),
//            '0' => Yii::t("translation", "registration"),
            '1' => Yii::t("translation", "active"),
        );
    }

    public function setStatus($id) {
        $list = array(
            '-1' => Yii::t("translation", "ban"),
            '0' => Yii::t("translation", "registration"),
            '1' => Yii::t("translation", "active"),
        );
        return $list[$id];
    }

    public function getLink() {
        $url_link = $_SERVER['SERVER_NAME'] . '/' . Yii::app()->language . '/dashboard_share/index?key_id=';
        $text = '<div class="inline" id="a' . $this->id . '">' . $url_link . $this->key . '</div> <button data-clipboard-target="#a' . $this->id . '" id="dashboard_link_clipboard" type="submit" class="btn btn-default"><i class="fa fa-clipboard"></i></button>';
        return $text;
    }

}
