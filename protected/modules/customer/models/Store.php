<?php

/**
 * This is the model class for table "store".
 *
 * The followings are the available columns in table 'store':
 * @property integer $id
 * @property integer $store_category_id
 * @property string $storename
 * @property string $adress
 * @property string $zip
 * @property string $phone
 * @property string $email
 * @property string $note
 * @property string $lang
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $user_id
 * @property string $city
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property StoreCategory $storeCategory
 * @property User $user
 * @property StoreSeller[] $storeSellers
 * @property StoreTag[] $storeTags
 * @property TotalScoring[] $totalScorings
 */
class Store extends CActiveRecord {

    public $tags;
    public $sellers;

    public function tableName() {
        return 'store';
    }

    public function rules() {
        return array(
            array('email', 'email'),
            array('store_category_id, storename, zip, adress', 'required'),
            array('phone', 'numerical'),
            //          
            array('store_category_id, status, user_id', 'numerical', 'integerOnly' => true),
            array('storename, adress, phone, email, city', 'length', 'max' => 255),
            array('zip', 'length', 'max' => 10),
            array('lang', 'length', 'max' => 2),
            array('note, update_time, tags, sellers', 'safe'),
            array('id, store_category_id, storename, adress, zip, phone, email, note, lang, create_time, update_time, status, user_id, city', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'comments' => array(self::HAS_MANY, 'Comment', 'store_id'),
            'storeCategory' => array(self::BELONGS_TO, 'StoreCategory', 'store_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'storeSellers' => array(self::HAS_MANY, 'StoreSeller', 'store_id'),
            'storeTags' => array(self::HAS_MANY, 'StoreTag', 'store_id'),
            'totalScorings' => array(self::HAS_MANY, 'TotalScoring', 'store_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_category_id' => Yii::t("translation", "store_category_id"),
            'storename' => Yii::t("translation", "storename"),
            'adress' => Yii::t("translation", "adress"),
            'zip' => Yii::t("translation", "zip"),
            'phone' => Yii::t("translation", "phone"),
            'email' => Yii::t("translation", "email"),
            'note' => Yii::t("translation", "note"),
            'lang' => Yii::t("translation", "lang"),
            'create_time' => Yii::t("translation", "create_time"),
            'update_time' => Yii::t("translation", "update_time"),
            'status' => Yii::t("translation", "status"),
            'user_id' => Yii::t("translation", "customer"),
            'tags' => Yii::t("translation", "tags"),
            'sellers' => Yii::t("translation", "sellers"),
            'city' => Yii::t("translation", "city"),
        );
    }

    public function search() {

        $pagesize = 10;
        if (isset($_GET['page_size'])) {
            $pagesize = (int) $_GET['page_size'];
        }

        $criteria = new CDbCriteria;
        $criteria->alias = 'store';
        $criteria->compare('id', $this->id);
        $criteria->compare('store_category_id', $this->store_category_id);
        $criteria->compare('storename', $this->storename, true);
        $criteria->compare('adress', $this->adress, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('status', $this->status);
//        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->compare('city', $this->city, true);
        //
        if (!empty($this->tags)) {
            $criteria->with = array('storeTags' => array(
                    'condition' => 'tag_id = :tagID',
                    'params' => array(':tagID' => $this->tags),
                    'together' => true,
            ));
        }

        if (!empty($this->sellers)) {
            $criteria->with = array('storeSellers' => array(
                    'alias' => 'store_seller',
                    'condition' => 'store_seller.user_id = :userID',
                    'params' => array(':userID' => $this->sellers),
                    'together' => true,
            ));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pagesize,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function defaultScope() {
        return array(
            'alias' => 'store',
            'condition' => "store.user_id='" . Yii::app()->user->id . "'",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            $this->create_time = new CDbExpression('NOW()');
            $this->lang = Yii::app()->language;
        } else {
            $this->update_time = new CDbExpression('NOW()');
        }

        return parent::beforeSave();
    }

    protected function afterSave() {
        if ($this->scenario == "import_store") {
            $model = new StoreTag;
            $model->store_id = $this->id;
            $model->tag_id = $this->tags;
            $model->save();
            //
            $model_seller = new StoreSeller;
            $model_seller->store_id = $this->id;
            $model_seller->user_id = $this->sellers;
            $model_seller->save();
        } else {
            $models = StoreTag::model()->findAllByAttributes(array('store_id' => $this->id));
            if (!empty($models)) {
                foreach ($models as $key => $value) {
                    $value->delete();
                }
            }
            if (!empty($this->tags)) {
                foreach ($this->tags as $key => $value) {
                    $tag = Tag::model()->findByPk((int) $value);
                    if (!empty($tag)) {
                        $model = new StoreTag;
                        $model->store_id = $this->id;
                        $model->tag_id = $value;
                        $model->save();
                    }
                }
            }
            //
            $seller = StoreSeller::model()->findAllByAttributes(array('store_id' => $this->id));
            if (!empty($seller)) {
                foreach ($seller as $key => $value) {
                    $value->delete();
                }
            }
            if (!empty($this->sellers)) {
                foreach ($this->sellers as $key => $value) {
                    $seller_model = Seller::model()->findByPk((int) $value);
                    if (!empty($seller_model)) {
                        $model_seller = new StoreSeller;
                        $model_seller->store_id = $this->id;
                        $model_seller->user_id = $value;
                        if (!$model_seller->save()) {
                            throw new CHttpException(404, 'System Error');
                        }
                    }
                }
            }
        }
        return parent::afterSave();
    }

    protected function beforeDelete() {
        $models = StoreTag::model()->findAllByAttributes(array('store_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $seller = StoreSeller::model()->findAllByAttributes(array('store_id' => $this->id));
        if (!empty($seller)) {
            foreach ($seller as $key => $value) {
                $value->delete();
            }
        }
        return parent::beforeDelete();
    }

    public function getStatus() {
        return array(
            '-1' => Yii::t("translation", "ban"),
            '0' => Yii::t("translation", "registration"),
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

    public function getStoreCategoryId() {
        $models = StoreCategory::model()->findAll();
        switch (Yii::app()->language) {
//            case 'en':
//                $list = CHtml::listData($models, 'id', 'translation_en');
//                break;
//            case 'sv':
//                $list = CHtml::listData($models, 'id', 'translation_sv');
//                break;
//            case 'no':
//                $list = CHtml::listData($models, 'id', 'translation_no');
//                break;
//            case 'da':
//                $list = CHtml::listData($models, 'id', 'translation_da');
//                break;
//            case 'fi':
//                $list = CHtml::listData($models, 'id', 'translation_fi');
//                break;
//            case 'de':
//                $list = CHtml::listData($models, 'id', 'translation_de');
//                break;

            default:
                $list = CHtml::listData($models, 'id', 'title');
                break;
        }

        return $list;
    }

    public function setStoreCategoryId($id) {
        $model = StoreCategory::model()->findByPk($id);
        if (empty($model)) {
            return '---';
//            throw new CHttpException(404, 'System Error');
        }

        switch (Yii::app()->language) {
//            case 'en':
//                $name = $model->translation_en;
//                break;
//            case 'sv':
//                $name = $model->translation_sv;
//                break;
//            case 'no':
//                $name = $model->translation_no;
//                break;
//            case 'da':
//                $name = $model->translation_da;
//                break;
//            case 'fi':
//                $name = $model->translation_fi;
//                break;
//            case 'de':
//                $name = $model->translation_de;
//                break;

            default:
                $name = $model->title;
                break;
        }

        return $name;
    }

    public function getTags() {
        $criteria = new CDbCriteria();
        $criteria->order = 'title ASC';
        $models = Tag::model()->findAll($criteria);
        $list = CHtml::listData($models, 'id', 'title');
        return $list;
    }

    public function getAllTags() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'store_id = :StoreId';
        $criteria->params = array(':StoreId' => $this->id);
        $models = StoreTag::model()->findAll($criteria);
        $string = '';
        foreach ($models as $key => $value) {
            $string .= $value->tag->title;
            $string .= '; ';
        }

        return $string;
    }

    public function getSellers() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'who_created = :WhoCreated';
        $criteria->params = array(':WhoCreated' => Yii::app()->user->id);
        $models = User::model()->findAll($criteria);
        $list = CHtml::listData($models, 'id', 'name');
        return $list;
    }

    public function getAllSellers() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'store_id = :StoreId';
        $criteria->params = array(':StoreId' => $this->id);
        $models = StoreSeller::model()->findAll($criteria);
        $string = '';
        foreach ($models as $key => $value) {
            $string .= $value->user->name;
            $string .= '; ';
        }

        return $string;
    }

    public function getAllTagsForExport() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'store_id = :StoreId';
        $criteria->params = array(':StoreId' => $this->id);
        $models = StoreTag::model()->findAll($criteria);
        $string = '';
        $count = count($models);
        $count--;
        foreach ($models as $key => $value) {
            if ($count == $key) {
                $string .= $value->tag->title;
            } else {
                $string .= $value->tag->title;
                $string .= ', ';
            }
        }

        return $string;
    }

    public function getAllSellersForExport() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'store_id = :StoreId';
        $criteria->params = array(':StoreId' => $this->id);
        $models = StoreSeller::model()->findAll($criteria);
        $string = '';
        $count = count($models);
        $count--;
        foreach ($models as $key => $value) {
            if ($count == $key) {
                $string .= $value->user->name;
            } else {
                $string .= $value->user->name;
                $string .= ', ';
            }
        }

        return $string;
    }

    public function getPercent($scoring_id) {
        $percent = 0;
        $models = TotalScoring::model()->resetScope()->findAllByAttributes(array('scoring_id' => $scoring_id, 'store_id' => $this->id));
        $count = count($models);
        if ($count != 0) {
            $all_percent = 0;
            foreach ($models as $key => $value) {
                $all_percent = $all_percent + $value->percent;
            }
            $percent = $all_percent / $count;
            $percent = floor($percent);
        }
        return $percent;
    }

}
