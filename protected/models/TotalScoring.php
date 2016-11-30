<?php

/**
 * This is the model class for table "total_scoring".
 *
 * The followings are the available columns in table 'total_scoring':
 * @property integer $id
 * @property integer $scoring_id
 * @property integer $store_id
 * @property integer $percent
 * @property integer $user_id
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property AnswerDescription[] $answerDescriptions
 * @property AnswerNote[] $answerNotes
 * @property AnswerUpload[] $answerUploads
 * @property Scoring $scoring
 * @property Store $store
 * @property User $user
 */
class TotalScoring extends CActiveRecord {

    public function tableName() {
        return 'total_scoring';
    }

    public function rules() {
        return array(
            array('scoring_id, store_id', 'required'),
            array('scoring_id, store_id, percent, user_id', 'numerical', 'integerOnly' => true),
            array('id, scoring_id, store_id, percent, user_id, date_update', 'safe', 'on' => 'search'),
            array('date_update', 'safe'),
        );
    }

    public function relations() {
        return array(
            'answerDescriptions' => array(self::HAS_MANY, 'AnswerDescription', 'total_scoring_id'),
            'answerNotes' => array(self::HAS_MANY, 'AnswerNote', 'total_scoring_id'),
            'answerUploads' => array(self::HAS_MANY, 'AnswerUpload', 'total_scoring_id'),
            'scoring' => array(self::BELONGS_TO, 'Scoring', 'scoring_id'),
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'scoring_id' => Yii::t("translation", "scoring_id"),
            'store_id' => Yii::t("translation", "store_id"),
            'percent' => Yii::t("translation", "percent"),
            'user_id' => Yii::t("translation", "user_id"),
            'date_update' => Yii::t("translation", "date_update"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('scoring_id', $this->scoring_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('percent', $this->percent);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('date_update', $this->date_update, true);

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

    protected function beforeDelete() {
        $answer_uploads = AnswerUpload::model()->resetScope()->findAllByAttributes(array('total_scoring_id' => $this->id));
        if (!empty($answer_uploads)) {
            foreach ($answer_uploads as $key => $value) {
                $value->delete();
            }
        }
        //
        $answer_description = AnswerDescription::model()->resetScope()->findAllByAttributes(array('total_scoring_id' => $this->id));
        if (!empty($answer_description)) {
            foreach ($answer_description as $key => $value) {
                $value->delete();
            }
        }
        //
        $answer_note = AnswerNote::model()->resetScope()->findAllByAttributes(array('total_scoring_id' => $this->id));
        if (!empty($answer_note)) {
            foreach ($answer_note as $key => $value) {
                $value->delete();
            }
        }

        //
        $logs_total = LogTotalScoring::model()->deleteAllByAttributes(array('total_scoring_id' => $this->id));

        return parent::beforeDelete();
    }

    public function changePercent() {
        $criteria = new CDbCriteria;
        $criteria->select = 'answer, scoring_description_id';
        $criteria->condition = 'total_scoring_id=:totalScoringId';
        $criteria->params = array(':totalScoringId' => $this->id);
        $models_a = AnswerDescription::model()->findAll($criteria);
        $models_a = CHtml::listData($models_a, 'scoring_description_id', 'answer');
        //
        $criteria2 = new CDbCriteria;
        $criteria2->select = 'id, point';
        $criteria2->condition = 'scoring_id=:scoringID';
        $criteria2->params = array(':scoringID' => $this->scoring_id);
        $models_d = ScoringDescription::model()->findAll($criteria2);
        $models_d = CHtml::listData($models_d, 'id', 'point');
        // ------------------- //
        $criteria3 = new CDbCriteria;
        $criteria3->select = 'image, scoring_image_upload_id';
        $criteria3->condition = 'total_scoring_id=:totalScoringId';
        $criteria3->params = array(':totalScoringId' => $this->id);
        $models_b = AnswerUpload::model()->findAll($criteria3);
        $models_b = CHtml::listData($models_b, 'scoring_image_upload_id', 'image');
        //
        $criteria4 = new CDbCriteria;
        $criteria4->select = 'id, point';
        $criteria4->condition = 'scoring_id=:scoringID';
        $criteria4->params = array(':scoringID' => $this->scoring_id);
        $models_c = ScoringImageUpload::model()->findAll($criteria4);
        $models_c = CHtml::listData($models_c, 'id', 'point');


        // ARTICLE BEGIN
        $criteria5 = new CDbCriteria;
        $criteria5->select = 'answer, article_point_id';
        $criteria5->condition = 'total_scoring_id=:totalScoringId';
        $criteria5->params = array(':totalScoringId' => $this->id);
        $models_article = AnswerArticle::model()->findAll($criteria5);
        $models_article = CHtml::listData($models_article, 'article_point_id', 'answer');

        $criteria6 = new CDbCriteria;
        $criteria6->select = 'id, point';
        $criteria6->condition = 'scoring_id=:scoringID';
        $criteria6->params = array(':scoringID' => $this->scoring_id);
        $models_article_point = ArticlePoint::model()->findAll($criteria6);
        $models_article_point = CHtml::listData($models_article_point, 'id', 'point');
        // ARTICLE END
        // 
        // 
        // Create new array id, point, answer
        $array = NULL;
        foreach ($models_d as $key => $value) {
            $array[] = array('id' => $key, 'point' => $value, 'answer' => empty($models_a[$key]) ? "0" : $models_a[$key]);
        }

        // ARTICLE BEGIN
        foreach ($models_article_point as $key => $value) {
            $array[] = array('id' => $key, 'point' => $value, 'answer' => empty($models_article[$key]) ? "0" : $models_article[$key]);
        }
        // ARTICLE END

        foreach ($models_c as $key => $value) {
            $answer = 0;
            if (isset($models_b[$key])) {
                $answer = 1;
            }
            $array[] = array('id' => $key, 'point' => $value, 'answer' => $answer);
        }

//        $count = count($array);
        $max_sum = 0;
        $check_sum = 0;
        foreach ($array as $key => $value) {
            $max_sum = $max_sum + $value['point'];
            if ($value['answer'] == 1) {
                $check_sum = $check_sum + $value['point'];
            }
        }
        $x = 100 * $check_sum / $max_sum;
        $x = floor($x);
        // LOG       
        LogTotalScoring::model()->logSave($this->id, $this->percent);
        $this->percent = $x;
        $this->save();
//        return $x;
    }

    public function lastUploadImage() {
        $model = AnswerUpload::model()->resetScope()->findByAttributes(array('total_scoring_id' => $this->id));

        return $model;
    }

    public function getTotalSumSeller($scoring_id, $user_id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :ScoringId AND user_id = :UserId';
        $criteria->limit = '20';
        $criteria->order = 'date_update DESC';
        $criteria->params = array(':ScoringId' => $scoring_id, ':UserId' => $user_id);
        $models = self::model()->resetScope()->findAll($criteria);
        $sum = 0;
        $count = 0;
        foreach ($models as $key => $value) {
            $sum = $sum + $value->percent;
            $count++;
        }
        if ($count != 0) {
            $sum = $sum / $count;
            $sum = floor($sum);
        }
        return $sum;
    }

    public function getSellerRecentActivety() {
        $array = array();
        $count = 0;
        $models = User::model()->TeamUsers;
        $list_sellers = CHtml::listData($models, 'id', 'id');
        // Надо подумать что делать
        foreach ($list_sellers as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->limit = '100';
            $criteria->condition = 'user_id = :userId';
            $criteria->params = array(':userId' => $value);
            $criteria->order = 'date_update DESC';
            $total_scorings = self::model()->resetScope()->findAll($criteria);
            foreach ($total_scorings as $key2 => $value2) {
                if (!empty($value2->date_update)) {
                    $array[$value2->date_update] = $value2;
                }
            }
        }
        krsort($array);
        $array = array_slice($array, 0, 10);

        return $array;
    }

    public function getAdminRecentActivety($search_seller = NULL) {
        $array = array();
        $count = 0;
        if ($search_seller === NULL) {
            $models = Seller::model()->findAll();
        } else {
            $criteria = new CDbCriteria;
            $criteria->compare('name', $search_seller, true);
            $models = Seller::model()->findAll($criteria);
        }

        $list_sellers = CHtml::listData($models, 'id', 'id');

        foreach ($list_sellers as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->limit = '100';
            $criteria->condition = 'user_id = :userId';
            $criteria->params = array(':userId' => $value);
            $criteria->order = 'date_update DESC';
            $total_scorings = self::model()->resetScope()->findAll($criteria);
            foreach ($total_scorings as $key2 => $value2) {
                if (!empty($value2->date_update)) {
                    $array[$value2->date_update] = $value2;
                }
            }
        }
        krsort($array);
        $array = array_slice($array, 0, 10);
        return $array;
    }

    public function getAdminRecentActivetyForShare($user_id) {
        $array = array();
        $count = 0;
        $models = User::model()->resetScope()->findAllByAttributes(array('who_created' => $user_id));
        $list_sellers = CHtml::listData($models, 'id', 'id');

        foreach ($list_sellers as $key => $value) {
            $criteria = new CDbCriteria;
            $criteria->limit = '100';
            $criteria->condition = 'user_id = :userId';
            $criteria->params = array(':userId' => $value);
            $criteria->order = 'date_update DESC';
            $total_scorings = self::model()->resetScope()->findAll($criteria);
            foreach ($total_scorings as $key2 => $value2) {
                if (!empty($value2->date_update)) {
                    $array[$value2->date_update] = $value2;
                }
            }
        }
        krsort($array);
        $array = array_slice($array, 0, 10);
        return $array;
    }

    public function getTopSellers($id = NULL) {
        $array = array();
        $models = Seller::model()->findAll();
        $list_sellers = CHtml::listData($models, 'id', 'id');

        foreach ($list_sellers as $key => $value) {
            $sum_percent = 0;
            $criteria = new CDbCriteria;
            $criteria->select = 'id, percent';
            if (!empty($id)) {
                $criteria->condition = 'user_id = :userId && scoring_id = :scoringId';
                $criteria->params = array(':userId' => $value, ':scoringId' => $id);
            } else {
                $criteria->condition = 'user_id = :userId';
                $criteria->params = array(':userId' => $value);
            }

            $total_scorings = self::model()->resetScope()->findAll($criteria);
            $list_total_scorings = CHtml::listData($total_scorings, 'id', 'percent');
            $count = 0;
            foreach ($list_total_scorings as $key2 => $value2) {
                $sum_percent = $sum_percent + $value2;
                $count++;
            }
            if ($count != 0) {
                $sum_percent = $sum_percent / $count;
                $sum_percent = floor($sum_percent);
            }

            $array[] = array(
                'sum_percent' => $sum_percent,
                'user_id' => $value,
            );
        }
        arsort($array);
        return $array;
    }

    //*** ( *** ) ***//

    public function getShareTopSellers($who, $id = NULL) {
        $array = array();
        $criteria = new CDbCriteria;
        $criteria->condition = 'who_created = :whoCreated';
        $criteria->params = array(':whoCreated' => $who);
        $models = Seller::model()->findAll($criteria);
        $list_sellers = CHtml::listData($models, 'id', 'id');

        foreach ($list_sellers as $key => $value) {
            $sum_percent = 0;
            $criteria = new CDbCriteria;
            $criteria->select = 'id, percent';
            if (!empty($id)) {
                $criteria->condition = 'user_id = :userId && scoring_id = :scoringId';
                $criteria->params = array(':userId' => $value, ':scoringId' => $id);
            } else {
                $criteria->condition = 'user_id = :userId';
                $criteria->params = array(':userId' => $value);
            }

            $total_scorings = self::model()->resetScope()->findAll($criteria);
            $list_total_scorings = CHtml::listData($total_scorings, 'id', 'percent');
            $count = 0;
            foreach ($list_total_scorings as $key2 => $value2) {
                $sum_percent = $sum_percent + $value2;
                $count++;
            }
            if ($count != 0) {
                $sum_percent = $sum_percent / $count;
                $sum_percent = floor($sum_percent);
            }

            $array[] = array(
                'sum_percent' => $sum_percent,
                'user_id' => $value,
            );
        }
        arsort($array);
        return $array;
    }

    public function getLastPercent() {
        $diff = 0;
        $model = LogTotalScoring::model()->findByAttributes(array('total_scoring_id' => $this->id));
        if (!empty($model)) {
            $diff = $this->percent - $model->last_percent;
            if ($diff > 0) {
                $diff = '+' . $diff;
            }
        }

        return $diff;
    }

    public function getNameScoring() {
        $model = Scoring::model()->resetScope()->findByPk($this->scoring_id);
        return empty($model) ? '' : $model->title;
    }

}
