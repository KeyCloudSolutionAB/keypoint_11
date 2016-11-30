<?php

/**
 * This is the model class for table "scoring".
 *
 * The followings are the available columns in table 'scoring':
 * @property integer $id
 * @property string $title
 * @property string $start_time
 * @property string $end_time
 * @property string $note
 * @property string $lang
 * @property integer $status
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property FilterScorlist[] $filterScorlists
 * @property User $user
 * @property ScoringCategory[] $scoringCategories
 * @property ScoringDescription[] $scoringDescriptions
 * @property ScoringImage[] $scoringImages
 * @property ScoringImageUpload[] $scoringImageUploads
 * @property ScoringSeller[] $scoringSellers
 * @property ScoringTag[] $scoringTags
 * @property TotalScoring[] $totalScorings
 */
class Scoring extends CActiveRecord {

    public function tableName() {
        return 'scoring';
    }

    public function rules() {
        return array(
            array('title, start_time, end_time', 'required'),
            array('status, user_id', 'numerical', 'integerOnly' => true),
            array('title, note', 'length', 'max' => 255),
            array('lang', 'length', 'max' => 2),
            array('id, title, start_time, end_time, note, lang, status, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'filterScorlists' => array(self::HAS_MANY, 'FilterScorlist', 'scoring_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'scoringCategories' => array(self::HAS_MANY, 'ScoringCategory', 'scoring_id'),
            'scoringDescriptions' => array(self::HAS_MANY, 'ScoringDescription', 'scoring_id'),
            'scoringImages' => array(self::HAS_MANY, 'ScoringImage', 'scoring_id'),
            'scoringImageUploads' => array(self::HAS_MANY, 'ScoringImageUpload', 'scoring_id'),
            'scoringSellers' => array(self::HAS_MANY, 'ScoringSeller', 'scoring_id'),
            'scoringTags' => array(self::HAS_MANY, 'ScoringTag', 'scoring_id'),
            'totalScorings' => array(self::HAS_MANY, 'TotalScoring', 'scoring_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => Yii::t("translation", "title"),
            'start_time' => Yii::t("translation", "start_time"),
            'end_time' => Yii::t("translation", "end_time"),
            'note' => Yii::t("translation", "note"),
            'lang' => Yii::t("translation", "lang"),
            'status' => Yii::t("translation", "status"),
            'user_id' => Yii::t("translation", "user_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('end_time', $this->end_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ============================== //

    public function defaultScope() {
        $today = date("Y-m-d H:i:s");
        return array(
            'condition' => "start_time < '" . $today . '\'' . ' AND ' . "end_time > '" . $today . '\'',
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            $this->lang = Yii::app()->language;
            $this->status = 0;
        }

        $this->start_time = date("Y-m-d", strtotime($this->start_time));
        $this->end_time = date("Y-m-d", strtotime($this->end_time));

        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->start_time = date("d.m.Y", strtotime($this->start_time));
        $this->end_time = date("d.m.Y", strtotime($this->end_time));

        return parent::afterFind();
    }

    public function getPercent() {
        $models = TotalScoring::model()->resetScope()->findAllByAttributes(array('scoring_id' => $this->id));
        $possible_store = count($this->getCat());
        $sum_percent = 0;
        $count = 0;
        foreach ($models as $key => $value) {
            $sum_percent += $value->percent;
            $count++;
        }
        if ($count != 0) {
            $sum_percent = $sum_percent / $possible_store;
            $sum_percent = floor($sum_percent);
        }
        return $sum_percent;
    }

    // Everage% of mesured store
    public function getPercentMiss() {
        $models = TotalScoring::model()->resetScope()->findAllByAttributes(array('scoring_id' => $this->id));
        $possible_store = count($this->getCat());
        $missing_store = $this->getMissingStore();
        $residue = $possible_store - $missing_store;
        $sum_percent = 0;
        $count = 0;
        foreach ($models as $key => $value) {
            $sum_percent += $value->percent;
            $count++;
        }
        if ($count != 0) {
            if ($residue == 0) {
                $sum_percent = 0;
            } else {
                $sum_percent = $sum_percent / $residue;
            }

            $sum_percent = floor($sum_percent);
        }
        return $sum_percent;
    }

    // Seller

    public function getPossibleStore($q = NULL) {

        $scoring_categories = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $this->id));
        $all_store = array();
        foreach ($scoring_categories as $key => $value) {
            if (!empty($q)) {
                $connection = Yii::app()->db;
                $text = $q;
                $store_category_id = $value->store_category_id;
                $sql = "SELECT * FROM store WHERE store_category_id = $store_category_id AND `storename` LIKE '%$text%' UNION SELECT * FROM store WHERE store_category_id = $store_category_id AND `adress` LIKE '%$text%'";
                $command = $connection->createCommand($sql);
                $models = $command->queryAll();

//                $criteria = new CDbCriteria;
//                $criteria->condition = 'store_category_id = :storeCategoryID';
//                $criteria->params = array(':storeCategoryID' => $value->store_category_id);
//                $criteria->addSearchCondition('storename', $q);
//                $models1 = Store::model()->findAll($criteria);
            } else {
                $models = Store::model()->findAllByAttributes(array('store_category_id' => $value->store_category_id));
            }

            if (!empty($models)) {
                foreach ($models as $key2 => $value2) {
                    $all_store[] = $value2;
                }
            }
        }

        // Store где я есть в StoreSeller
        $all_my_store = StoreSeller::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        $all_my_store_list = CHtml::listData($all_my_store, 'store_id', 'store_id');
        $new_all_store = array();
        foreach ($all_store as $key => $value) {
            $id = $value['id'];
            if (!empty($all_my_store_list[$id])) {
                $new_all_store[] = $value;
            }
        }

        return $new_all_store;
    }

    public function getMissingStores() {
        $scoring_categories = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $this->id));
        $all_store = array();
        foreach ($scoring_categories as $key => $value) {
            $models = Store::model()->findAllByAttributes(array('store_category_id' => $value->store_category_id));
            if (!empty($models)) {
                foreach ($models as $key2 => $value2) {
                    $all_store[] = $value2;
                }
            }
        }

        // Store где я есть в StoreSeller
        $all_my_store = StoreSeller::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        $all_my_store_list = CHtml::listData($all_my_store, 'store_id', 'store_id');
        $new_all_store = array();
        foreach ($all_store as $key => $value) {
            $id = $value['id'];
            if (!empty($all_my_store_list[$id])) {
                $new_all_store[] = $value;
            }
        }

        // Get Store percent > 0

        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringId AND percent > 0';
        $criteria->params = array(':scoringId' => $this->id);
        $criteria->select = 'store_id, percent';
        $total_scoring = TotalScoring::model()->findAll($criteria);
        $total_scoring = CHtml::listData($total_scoring, 'store_id', 'percent');
        // missing store
        $missing_store = NULL;
        foreach ($new_all_store as $key => $value) {
            $check_array = array_key_exists($value->id, $total_scoring);
            if ($check_array == FALSE) {
                $missing_store[] = $value;
            }
        }




        return $missing_store;
    }

    public function getImages() {
        $scoring_images = ScoringImage::model()->findAllByAttributes(array('scoring_id' => $this->id));
        return $scoring_images;
    }

    public function getUploadImages() {
        $scoring_upload_images = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $this->id));
        return $scoring_upload_images;
    }

    public function getAnswerUpload() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $this->id);
        $criteria->select = 'id';
        $total_scorings = TotalScoring::model()->findAll($criteria);

//        $total_scorings = TotalScoring::model()->findAllByAttributes(array('scoring_id' => $this->id));
        $models = NULL;
        foreach ($total_scorings as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringID';
            $criteria->params = array(':totalScoringID' => $value->id);
//            $criteria->select = 'id';
            $answer_uploads = AnswerUpload::model()->findAll($criteria);

//            $answer_uploads = AnswerUpload::model()->findAllByAttributes(array('total_scoring_id' => $value->id));
            foreach ($answer_uploads as $key2 => $value2) {
                $models[] = $value2;
            }
        }

        return $models;
    }

    //
    public function totalPercent() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $this->id);
        $criteria->select = 'id, percent';
        $models = TotalScoring::model()->findAll($criteria);


//        $models = TotalScoring::model()->findAllByAttributes(array('scoring_id' => $this->id));
        $all_total = 0;
        $total = 0;
        //
        $all_store = $this->getPossibleStore();

        $count = count($all_store);
        foreach ($models as $key => $value) {
            $total = $total + $value->percent;
        }
        if (!empty($count)) {
            $all_total = $total / $count;
            $all_total = floor($all_total);
        }
        return $all_total;
    }

    public function getMissingStore() {
        $missing_store = $this->getCat();
        $model_total_scoring = $this->getTotalScoring();
        $count = count($this->getCat()) - count($model_total_scoring);

        return $count;
    }

    public function getImageStore() {
        $image_store_array = array();
        $possible_store = $this->getCat();
        foreach ($possible_store as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'scoring_id = :ScoringId AND store_id = :StoreId AND percent > 0';
            $criteria->params = array(':ScoringId' => $this->id, ':StoreId' => $value->id);
            $models = TotalScoring::model()->resetScope()->findAll($criteria);
            foreach ($models as $key => $value) {
                $answer_uploads = AnswerUpload::model()->resetScope()->findAllByAttributes(array('total_scoring_id' => $value->id));
                foreach ($answer_uploads as $key => $value) {
                    $image_store_array[] = $value;
                }
            }
        }
        return $image_store_array;
    }

    private function getCat() {
        $all_store = array();
        $models = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $this->id));
        foreach ($models as $key => $value) {
            $all = Store::model()->findAllByAttributes(array('store_category_id' => $value->store_category_id));
            foreach ($all as $key => $value) {
                $all_store[$value->id] = $value;
            }
        }
        return $all_store;
    }

    private function getTotalScoring() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :ScoringId AND percent > 0';
        $criteria->params = array(':ScoringId' => $this->id);
        $models = TotalScoring::model()->resetScope()->findAll($criteria);
        return $models;
    }

    //

    public function getPossibleStore2() {
        $possible_store = $this->getCat();

        return $possible_store;
    }

    public function getMesuredStores() {
        $array = $this->getTotalScoring();
        $models = array();

        foreach ($array as $key => $value) {
            $models[] = $value->store;
        }

        return $models;
    }

    public function getListMissingStore() {
        $possible_store = $this->getCat();
        $model_total_scoring = $this->getTotalScoring();
        foreach ($model_total_scoring as $key => $value) {
            $model_total_scoring[$value->store_id] = $value->store_id;
        }
        $array = array();
        foreach ($possible_store as $key => $value) {
            if (isset($model_total_scoring[$key])) {
                
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

}
