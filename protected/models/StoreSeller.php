<?php

/**
 * This is the model class for table "store_seller".
 *
 * The followings are the available columns in table 'store_seller':
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Store $store
 * @property User $user
 */
class StoreSeller extends CActiveRecord {

    public function tableName() {
        return 'store_seller';
    }

    public function rules() {
        return array(
            array('store_id, user_id', 'required'),
            array('store_id, user_id', 'numerical', 'integerOnly' => true),
            array('id, store_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_id' => 'Store',
            'user_id' => 'User',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getMyStores($q = NULL) {
        $models = self::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        $array = NULL;

        if (!empty($q)) {
            foreach ($models as $key => $value) {
                $store_m = Store::model()->findByPk($value->store_id);
                if (!empty($store_m)) {
                    $pos = stripos($store_m->storename, $q);
                    $pos2 = stripos($store_m->city, $q);
                    if ($pos !== FALSE || $pos2 !== FALSE) {
                        $array[] = $store_m;
                    }
                }
            }
        } else {
            foreach ($models as $key => $value) {
                $array[] = Store::model()->findByPk($value->store_id);
            }
        }


        return $array;
    }

    public function getMyTeamStores($all_my_team_users, $q = NULL) {
        $array = NULL;


        if (!empty($q)) {
            if (!empty($all_my_team_users)) {
                foreach ($all_my_team_users as $key => $value) {
                    $models = self::model()->findAllByAttributes(array('user_id' => $value->id));
                    foreach ($models as $key => $value) {
                        $store_m = Store::model()->findByPk($value->store_id);
                        if (!empty($store_m)) {
                            $pos = stripos($store_m->storename, $q);
                            if ($pos !== FALSE) {
                                $array[] = $store_m;
                            }
                        }
                    }
                }
            }
        } else {
            if (!empty($all_my_team_users)) {
                foreach ($all_my_team_users as $key => $value) {
                    $models = self::model()->findAllByAttributes(array('user_id' => $value->id));
                    foreach ($models as $key => $value) {
                        $array[] = Store::model()->findByPk($value->store_id);
                    }
                }
            }
        }




        return $array;
    }

    public function checkTeamStores($id) {
        $all_my_team_users = User::model()->MyTeamUsers;
        $my_team_stores = $this->getMyTeamStores($all_my_team_users);
        $bool = FALSE;

        foreach ($my_team_stores as $key => $value) {
            if ($value->id == $id) {
                $bool = TRUE;
                break;
            }
        }

        return $bool;
    }

}
