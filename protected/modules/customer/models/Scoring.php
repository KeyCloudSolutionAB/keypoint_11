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
//            'condition' => "lang='" . Yii::app()->language . "'",
            'condition' => "user_id='" . Yii::app()->user->id . "'",
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

    // ***************************** //

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

    public function getPossibleStore() {
        $possible_store = $this->getCat();

        return $possible_store;
    }

    public function getMissingStore() {
        $missing_store = $this->getCat();
        $model_total_scoring = $this->getTotalScoring();
        $count = count($this->getCat()) - count($model_total_scoring);

        return $count;
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

    public function getMesuredStores() {
        $array = $this->getTotalScoring();
        $models = array();

        foreach ($array as $key => $value) {
            $models[] = $value->store;
        }

        return $models;
    }

    protected function beforeDelete() {
        $models = TotalScoring::model()->resetScope()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringImage::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringTag::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //
        $models = ScoringSeller::model()->findAllByAttributes(array('scoring_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }
        //       

        return parent::beforeDelete();
    }

    public function archive() {
        $model = self::model()->findByPk($this->id);
        if ($model->status == 0) {
            $model->status = -1;
        } else {
            $model->status = 0;
        }

        $model->saveAttributes(array('status'));
    }

}
