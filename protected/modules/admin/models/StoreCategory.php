<?php

/**
 * This is the model class for table "store_category".
 *
 * The followings are the available columns in table 'store_category':
 * @property integer $id
 * @property string $title
 * @property string $translation_en
 * @property string $translation_sv
 * @property string $translation_no
 * @property string $translation_da
 * @property string $translation_fi
 * @property string $translation_de
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property FilterCategory[] $filterCategories
 * @property ScoringCategory[] $scoringCategories
 * @property Store[] $stores
 * @property User $user
 */
class StoreCategory extends CActiveRecord {

    public function tableName() {
        return 'store_category';
    }

    public function rules() {
        return array(
            //
            array('title', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title, translation_en, translation_sv, translation_no, translation_da, translation_fi, translation_de', 'length', 'max' => 255),
            array('id, title, translation_en, translation_sv, translation_no, translation_da, translation_fi, translation_de, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'filterCategories' => array(self::HAS_MANY, 'FilterCategory', 'store_category_id'),
            'scoringCategories' => array(self::HAS_MANY, 'ScoringCategory', 'store_category_id'),
            'stores' => array(self::HAS_MANY, 'Store', 'store_category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => Yii::t("translation", "title"),
            'translation_en' => Yii::t("translation", "translation_en"),
            'translation_sv' => Yii::t("translation", "translation_sv"),
            'translation_no' => Yii::t("translation", "translation_no"),
            'translation_da' => Yii::t("translation", "translation_da"),
            'translation_fi' => Yii::t("translation", "translation_fi"),
            'translation_de' => Yii::t("translation", "translation_de"),
            'user_id' => Yii::t("translation", "user_id"),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('translation_en', $this->translation_en, true);
        $criteria->compare('translation_sv', $this->translation_sv, true);
        $criteria->compare('translation_no', $this->translation_no, true);
        $criteria->compare('translation_da', $this->translation_da, true);
        $criteria->compare('translation_fi', $this->translation_fi, true);
        $criteria->compare('translation_de', $this->translation_de, true);
        $criteria->compare('user_id', Yii::app()->params['choose_customer']);

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
            'condition' => "user_id='" . Yii::app()->params['choose_customer'] . "'",
            'order' => "title ASC",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->params['choose_customer'];
        }

        return parent::beforeSave();
    }

    public function getName() {
        return $this->title;

        switch (Yii::app()->language) {
            case 'en':
                $name = $this->translation_en;
                break;
            case 'sv':
                $name = $this->translation_sv;
                break;
            case 'no':
                $name = $this->translation_no;
                break;
            case 'da':
                $name = $this->translation_da;
                break;
            case 'fi':
                $name = $this->translation_fi;
                break;
            case 'de':
                $name = $this->translation_de;
                break;

            default:
                $name = $this->translation_en;
                break;
        }

        return $name;
    }

    protected function beforeDelete() {
        $models = ScoringCategory::model()->resetScope()->findAllByAttributes(array('store_category_id' => $this->id));
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $value->delete();
            }
        }

        return parent::beforeDelete();
    }

}
