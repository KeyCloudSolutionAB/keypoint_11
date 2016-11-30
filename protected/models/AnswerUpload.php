<?php

/**
 * This is the model class for table "answer_upload".
 *
 * The followings are the available columns in table 'answer_upload':
 * @property integer $id
 * @property integer $total_scoring_id
 * @property integer $user_id
 * @property string $image
 * @property integer $scoring_image_upload_id
 *
 * The followings are the available model relations:
 * @property ScoringImageUpload $scoringImageUpload
 * @property TotalScoring $totalScoring
 * @property User $user
 */
class AnswerUpload extends CActiveRecord {

    public function tableName() {
        return 'answer_upload';
    }

    public function rules() {
        return array(
            array('total_scoring_id, scoring_image_upload_id', 'required'),
            array('total_scoring_id, user_id, scoring_image_upload_id', 'numerical', 'integerOnly' => true),
            array('image', 'length', 'max' => 255),
            array('id, total_scoring_id, user_id, image, scoring_image_upload_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'scoringImageUpload' => array(self::BELONGS_TO, 'ScoringImageUpload', 'scoring_image_upload_id'),
            'totalScoring' => array(self::BELONGS_TO, 'TotalScoring', 'total_scoring_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_scoring_id' => Yii::t("translation", "total_scoring_id"),
            'user_id' => Yii::t("translation", "user_id"),
            'image' => Yii::t("translation", "image"),
            'scoring_image_upload_id' => Yii::t("translation", "scoring_image_upload_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_scoring_id', $this->total_scoring_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('scoring_image_upload_id', $this->scoring_image_upload_id);

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

    public function behaviors() {
        return array(
            'uploadableFile' => array(
                'class' => 'application.components.UploadableFileBehavior',
                'savePathAlias' => 'webroot.upload_files.answer_upload',
                'allowEmpty' => $this->scenario == 'mysave' ? TRUE : FALSE,
            ),
        );
    }

    public function imageRotate($format, $file_url) {
        switch ($format) {
            case 'jpg':
                $source = imagecreatefromjpeg($file_url);

                break;

            case 'jpeg':
                $source = imagecreatefromjpeg($file_url);

                break;

            case 'png':
                $source = imagecreatefrompng($file_url);

                break;

            default:
                $source = imagecreatefromjpeg($file_url);
                break;
        }

        $exif = exif_read_data($file_url);

        if (!empty($exif)) {
            if (!empty($exif['Orientation'])) {
                $ort = $exif['Orientation'];
                if (!empty($ort)) {
                    switch ($ort) {
                        case 8:
                            $source = imagerotate($source, 90, 0);
                            break;
                        case 3:
                            $source = imagerotate($source, 180, 0);
                            break;
                        case 6:
                            $source = imagerotate($source, -90, 0);
                            break;
                    }

                    switch ($format) {
                        case 'jpg':
                            imagejpeg($source, $file_url);

                            break;

                        case 'jpeg':
                            imagejpeg($source, $file_url);

                            break;

                        case 'png':
                            imagepng($source, $file_url);

                            break;

                        default:
                            imagejpeg($source, $file_url);
                            break;
                    }
                }
            }
        }
        // Освобождаем память
        imagedestroy($source);
    }

}
