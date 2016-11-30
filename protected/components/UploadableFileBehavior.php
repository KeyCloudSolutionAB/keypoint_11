<?php

/**
 * @property string $savePath путь к директории, в которой сохраняем файлы
 */
class UploadableFileBehavior extends CActiveRecordBehavior {

    /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attributeName = 'image';

    /**
     * @var string алиас директории, куда будем сохранять файлы
     */
    public $savePathAlias = 'webroot.upload_files';

    /**
     * @var array сценарии валидации к которым будут добавлены правила валидации
     * загрузки файлов
     */
    public $scenarios = array('insert', 'update');

    /**
     * @var string типы файлов, которые можно загружать (нужно для валидации)
     */
    // public $fileTypes = 'doc,docx,xls,xlsx,odt,pdf';
    public $fileTypes = 'jpeg, jpg, png';
    public $allowEmpty = FALSE;

    /**
     * Шорткат для Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR.
     * Возвращает путь к директории, в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getSavePath() {
        return Yii::getPathOfAlias($this->savePathAlias) . DIRECTORY_SEPARATOR;
    }

    public function attach($owner) {
        parent::attach($owner);

        if (in_array($owner->scenario, $this->scenarios)) {
            // добавляем валидатор файла            
            if ($owner->scenario === 'insert') {
                $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array('types' => $this->fileTypes, 'allowEmpty' => $this->allowEmpty));
            }
            if ($owner->scenario === 'update') {
                $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array('types' => $this->fileTypes, 'allowEmpty' => TRUE));
            }
            $owner->validatorList->add($fileValidator);
        }
    }

    public function beforeSave($event) {
        $file = CUploadedFile::getInstance($this->owner, $this->attributeName);

        if ($this->owner->isNewRecord) {
            if (!empty($file)) {
                $uniq = uniqid();
                $format = preg_replace("/.*?\./", '', $file->name);
                $fileName = $uniq . '.' . $format;
                $this->owner->setAttribute($this->attributeName, $fileName);
                $file->saveAs($this->savePath . $fileName);
                $file_url = $this->savePath . $fileName;
                //

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

                try {
                    $exif = @exif_read_data($file_url);
                } catch (Exception $exp) {
                    $exif = false;
                }

//                error_reporting(0);
//                $exif = exif_read_data($file_url);

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


                            // Освобождаем память
                        }
                    }
                }
                imagedestroy($source);
            }
        } else {
            $model_name = get_class($this->owner);
            $model = $model_name::model()->findByPk($this->owner->id);
            $attribute = $this->attributeName;
            $model_attribute = $model->$attribute;

            if (!empty($file)) {
                if (!empty($model_attribute)) {
                    $this->deleteFile($model_attribute);
                }
                $uniq = uniqid();
                $format = preg_replace("/.*?\./", '', $file->name);
                $fileName = $uniq . '.' . $format;
                $this->owner->setAttribute($this->attributeName, $fileName);
                $file->saveAs($this->savePath . $fileName);
            } else {
                if (!empty($model_attribute)) {
                    $this->owner->setAttribute($this->attributeName, $model_attribute);
                } else {
                    $this->owner->setAttribute($this->attributeName, NULL);
                }
            }
        }
        return TRUE;
    }

    public function beforeDelete($event) {
        $this->deleteFile();
    }

    public function deleteFile($model_attribute = NULL) {
        if (!empty($model_attribute)) {
            $filePath = $this->savePath . $model_attribute;
        } else {
            $filePath = $this->savePath . $this->owner->getAttribute($this->attributeName);
        }
        if (@is_file($filePath))
            @unlink($filePath);
    }

}
