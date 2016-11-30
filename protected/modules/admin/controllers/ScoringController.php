<?php

class ScoringController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
            'ajaxOnly + delete_image',
            'ajaxOnly + change_position',
            'ajaxOnly + changeaddarticle',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'add_store_category_tag', 'add_team', 'del_image', 'archive', 'export', 'export2', 'export_info'),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'add_presentation_image', 'add_description', 'add_article'),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('admin', 'delete', 'delete_image', 'change_position', 'add_image_upload', 'changeaddarticle', 'article_check'),
                'roles' => array('administrator'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionExport2($id) {
        $coding = iconv_get_encoding('internal_encoding');

        if (function_exists('iconv') && $coding != 'UTF-8') {
            iconv_set_encoding("internal_encoding", "UTF-8");
        } else {
            ini_set("default_charset", "UTF-8");
        }

        $model = $this->loadModel($id);
        //
        $uniq = uniqid();
        $fileName = $uniq . '.csv';
        $dir = Yii::app()->request->baseUrl . 'upload_files/export_scoring/';
        $fp = fopen($dir . $fileName, "w+");
        fwrite($fp, pack("CCC", 0xef, 0xbb, 0xbf));
        fclose($fp);

        //

        $file = $dir . $fileName;
        $current = file_get_contents($file);
        $current .= Yii::t("translation", "scoring_name") . ': ' . $model->title . "\n";
        //        
        $all_stores = $model->PossibleStore;

        foreach ($all_stores as $key => $value) {
            $current .= CHtml::encode(trim($value->storename)) . ";";
            $current .= CHtml::encode(trim($value->AllSellersForExport)) . ";";
            $current .= CHtml::encode(trim($value->storeCategory->title)) . ";";
            $current .= CHtml::encode(trim($value->AllTagsForExport)) . ";";
            $current .= trim($value->getPercent($id)) . "%;";
            $all_dec = $model->AllScoringDescriptionForExport;
            foreach ($all_dec as $key => $value) {
                $current .= CHtml::encode(trim($value->description)) . ";";
            }
            $all_img = $model->AllScoringImageUploadForExport;
            foreach ($all_img as $key => $value) {
                $current .= CHtml::encode(trim($value->description)) . ";";
            }
            $current .= "\n";
        }
        file_put_contents($file, $current);
        Header("HTTP/1.1 200 OK");
        Header("Connection: close");
        Header("Content-Type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Content-Disposition: Attachment; filename=export.csv");
        Header("Content-Length: 50000");

        readfile($file);

        if (@is_file($file))
            @unlink($file);
    }

    public function actionExport($id) {
        $coding = iconv_get_encoding('internal_encoding');

        if (function_exists('iconv') && $coding != 'UTF-8') {
            iconv_set_encoding("internal_encoding", "UTF-8");
        } else {
            ini_set("default_charset", "UTF-8");
        }


        $model = $this->loadModel($id);
        //
        $uniq = uniqid();
        $fileName = $uniq . '.csv';
        $dir = Yii::app()->request->baseUrl . 'upload_files/export_scoring/';
        $fp = fopen($dir . $fileName, "w+");
        fwrite($fp, pack("CCC", 0xef, 0xbb, 0xbf));
        fclose($fp);

        //
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_description = ScoringDescription::model()->resetScope()->findAll($criteria);
        //
        // ARTICLE
        //
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_articles = ArticlePoint::model()->resetScope()->findAll($criteria);
        //
        // ARTICLE END
        //
        
        
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_images = ScoringImageUpload::model()->resetScope()->findAll($criteria);
        //
        $file = $dir . $fileName;
        $current = file_get_contents($file);
        $current .= Yii::t("translation", "scoring_name") . ': ' . $model->title . ';';
        $current .= ";;;;";
        foreach ($scoring_description as $key => $value) {
            $current .= CHtml::decode(trim($value->description)) . ";";
        }
        foreach ($scoring_articles as $key => $value) {
            $current .= CHtml::decode(trim($value->article->title)) . ";";
        }
        foreach ($scoring_images as $key => $value) {
            $current .= CHtml::decode(trim($value->description)) . ";";
        }
        $current .= "\n";
        //      
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->select = 'id, store_id, percent, user_id';
        $all_stores = TotalScoring::model()->resetScope()->findAll($criteria);

        $main_url = 'www.' . $_SERVER['HTTP_HOST'] . '/upload_files/answer_upload/';

        foreach ($all_stores as $key => $value) {
            $model_user = User::model()->resetScope()->findByPk($value->user_id);
            $model_store = Store::model()->resetScope()->findByPk($value->store_id);
            $current .= CHtml::decode(trim($model_store->storename)) . ";";
            $current .= CHtml::decode(trim($model_store->storeCategory->title)) . ";";
            $current .= CHtml::decode(trim($model_store->AllTagsForExport)) . ";";
            $current .= CHtml::decode(trim($model_user->name)) . ";";
            $current .= $value->percent . "%;";
            //
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_description = AnswerDescription::model()->resetScope()->findAll($criteria);
            $answer_description_list = CHtml::listData($answer_description, 'scoring_description_id', 'answer');
            //
            foreach ($scoring_description as $key2 => $value2) {
                if (isset($answer_description_list[$value2->id])) {
                    $current .= $answer_description_list[$value2->id] . ";";
                } else {
                    $current .= ";";
                }
            }
            //
            // ARTICLE
            //
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_article = AnswerArticle::model()->resetScope()->findAll($criteria);
            $answer_article_list = CHtml::listData($answer_article, 'article_point_id', 'answer');
            //
            foreach ($scoring_articles as $key4 => $value4) {
                if (isset($answer_article_list[$value4->id])) {
                    $current .= html_entity_decode($answer_article_list[$value4->id]) . ";";
                } else {
                    $current .= ";";
                }
            }
            //
            // ARTICLE
            //
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_upload = AnswerUpload::model()->resetScope()->findAll($criteria);
            $answer_upload_list = CHtml::listData($answer_upload, 'scoring_image_upload_id', 'image');
            //
            foreach ($scoring_images as $key3 => $value3) {
                if (isset($answer_upload_list[$value3->id])) {
                    $current .= $main_url . $answer_upload_list[$value3->id] . ";";
                } else {
                    $current .= ";";
                }
            }
            $current .= "\n";
        }
        file_put_contents($file, $current);

        Header("HTTP/1.1 200 OK");
        Header("Connection: close");
        Header("Content-Type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Content-Disposition: Attachment; filename=export.csv");
        Header("Content-Length: 50000");

        readfile($file);

        if (@is_file($file))
            @unlink($file);
    }

    public function actionAdd_image_upload($id) {
        $model = $this->loadModel($id);

        $last_model = ScoringImageUpload::model()->last_position()->findByAttributes(array('scoring_id' => $model->id));

        if (isset($_POST['Add'])) {
            $add_array = $_POST['Add'];
            if (is_array($add_array) && !empty($add_array)) {
                $position = 0;
                $bool = FALSE;
                $models = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $model->id));

                if (!empty($models)) {
                    foreach ($models as $key2 => $value2) {
                        $models2[$value2->id] = $value2->id;
                    }
                }

                foreach ($add_array as $key => $value) {
                    if (!empty($models2) && !empty($value['id'])) {
                        $check_array = array_key_exists($value['id'], $models2);
                    } else {
                        $check_array = FALSE;
                    }

                    if ($check_array) {
                        $id = (int) $value['id'];
                        $model_scoring_description = ScoringImageUpload::model()->findByPk($id);
                        $model_scoring_description->description = $value['description'];
                        $model_scoring_description->point = $value['point'];
                        $model_scoring_description->position = $position;
                        $model_scoring_description->scoring_id = $model->id;
                        if ($model_scoring_description->save()) {
                            $bool = TRUE;
                            $position++;
                        }
                    } else {
                        $model_scoring_description = new ScoringImageUpload;
                        $model_scoring_description->description = $value['description'];
                        $model_scoring_description->point = $value['point'];
                        $model_scoring_description->position = $position;
                        $model_scoring_description->scoring_id = $model->id;
                        if ($model_scoring_description->save()) {
                            $bool = TRUE;
                            $position++;
                        }
                    }
                }

                foreach ($models as $key => $value) {
                    $bool2 = FALSE;
                    foreach ($add_array as $key2 => $value2) {
                        if (!empty($value2['id'])) {
                            if ($value2['id'] == $value->id) {
                                $bool2 = TRUE;
                            }
                        }
                    }
                    if ($bool2 == FALSE) {
                        $value->delete();
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                    $this->refresh();
                }
            }
        }

        $models = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $this->render('add_image_upload', array(
            'model' => $model,
            'models' => $models,
            'last_model' => $last_model
        ));
    }

    public function actionAdd_description($id) {
        $model = $this->loadModel($id);

        $last_model = ScoringDescription::model()->last_position()->findByAttributes(array('scoring_id' => $model->id));

        if (isset($_POST['Add'])) {
            $add_array = $_POST['Add'];
            if (is_array($add_array) && !empty($add_array)) {

                $position = 0;
                $bool = FALSE;
                $models = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $model->id));
                //
                if (!empty($models)) {
                    foreach ($models as $key2 => $value2) {
                        $models2[$value2->id] = $value2->id;
                    }
                }

                foreach ($add_array as $key => $value) {
                    if (!empty($models2) && !empty($value['id'])) {
                        $check_array = array_key_exists($value['id'], $models2);
                    } else {
                        $check_array = FALSE;
                    }

                    $num = 0;
                    if (isset($value['num'])) {
                        if ($value['num'] == 'on') {
                            $num = 1;
                        }
                    }

                    if ($check_array) {
                        $id = (int) $value['id'];
                        $model_scoring_description = ScoringDescription::model()->findByPk($id);
                        $model_scoring_description->description = $value['description'];
                        $model_scoring_description->point = $value['point'];
                        $model_scoring_description->num = $num;
                        $model_scoring_description->position = $position;
                        $model_scoring_description->scoring_id = $model->id;
                        if ($model_scoring_description->save()) {
                            $bool = TRUE;
                            $position++;
                        }
                    } else {
                        $model_scoring_description = new ScoringDescription;
                        $model_scoring_description->description = $value['description'];
                        $model_scoring_description->point = (int) $value['point'];
                        $model_scoring_description->num = $num;
                        $model_scoring_description->position = $position;
                        $model_scoring_description->scoring_id = $model->id;
                        if ($model_scoring_description->save()) {
                            $bool = TRUE;
                            $position++;
                        }
                    }
                }

                foreach ($models as $key => $value) {
                    $bool2 = FALSE;
                    foreach ($add_array as $key2 => $value2) {
                        if (!empty($value2['id'])) {
                            if ($value2['id'] == $value->id) {
                                $bool2 = TRUE;
                            }
                        }
                    }
                    if ($bool2 == FALSE) {
                        $value->delete();
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
                    $this->refresh();
                }
            }
        }

        if (isset($_POST['Import'])) {
            $new_import = array();
            $text = $_POST['Import'];
            $text = strip_tags($text);
            $pieces = explode("\n", $text);

            foreach ($pieces as $key => $value) {
                $value = CHtml::encode($value);
                $value = trim($value); // удаляем пробелы по бокам
                $value = preg_replace("/ +/", " ", $value); // множественные пробелы заменяем на одинарные
                $value = str_replace(array("\t"), " ", $value);
                $new_import[$key]['description'] = trim(substr($value, 0, -1));
                $new_import[$key]['point'] = substr($value, -1);
            }
            if (!empty($last_model)) {
                $position = $last_model->position;
            } else {
                $position = 0;
            }

            $bool = FALSE;

            foreach ($new_import as $key => $value) {
                $position++;
                $model_scoring_description = new ScoringDescription;
                $model_scoring_description->description = $value['description'];
                $model_scoring_description->point = (int) $value['point'];
                $model_scoring_description->position = $position;
                $model_scoring_description->scoring_id = $model->id;
                if ($model_scoring_description->save()) {
                    $bool = TRUE;
                }
            }
            if ($bool) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_import_information"));
                $this->refresh();
            }
        }

        $models = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $this->render('add_description', array(
            'model' => $model,
            'models' => $models,
            'last_model' => $last_model
        ));
    }

    public function actionDelete_image($id, $image_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            if (!empty($model)) {
                $model_scoring_image = ScoringImage::model()->findByAttributes(array('scoring_id' => $id, 'id' => $image_id));
                if (!empty($model_scoring_image)) {
                    if ($model_scoring_image->delete()) {
                        
                    }
                }
            } else {
                Yii::app()->end();
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionChange_position($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            if (!empty($model) && !empty($_POST['position']) && is_array($_POST['position'])) {
                $array = $_POST['position'];
                $array = array_reverse($array);
                foreach ($array as $key => $value) {
                    $model = ScoringImage::model()->findByPk($value);
                    $model->position = $key;
                    $model->saveAttributes(array('position'));
                }
            } else {
                Yii::app()->end();
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionAdd_presentation_image($id) {
        $model = $this->loadModel($id);

        $model_scoring_image = new ScoringImage;

        if (isset($_POST['ScoringImage'])) {
            $model_scoring_image->attributes = $_POST['ScoringImage'];
            $model_scoring_image->scoring_id = $model->id;
            if ($model_scoring_image->validate()) {
                if ($model_scoring_image->save()) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
                    $this->refresh();
                }
            }
        }

        $models = ScoringImage::model()->findAllByAttributes(array('scoring_id' => $model->id));


        $this->render('add_presentation_image', array(
            'model' => $model,
            'model_scoring_image' => $model_scoring_image,
            'models' => $models,
        ));
    }

    public function actionAdd_team($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['yt0'])) {
            $all_sellers = ScoringSeller::model()->findAllByAttributes(array('scoring_id' => $model->id));
            foreach ($all_sellers as $key => $value) {
                $value->delete();
            }
            //
            if (isset($_POST['Sellers'])) {
                $array_sellers = $_POST['Sellers'];

                if (is_array($array_sellers)) {
                    if (count($array_sellers) > 0) {
                        foreach ($array_sellers as $key => $value) {
                            $seller = Seller::model()->findByPk($value);
                            if (!empty($seller)) {
                                $model_ss = ScoringSeller::model()->findByAttributes(array('scoring_id' => $model->id, 'user_id' => $value));
                                if (empty($model_ss)) {
                                    $model_ss = new ScoringSeller;
                                    $model_ss->scoring_id = $model->id;
                                    $model_ss->user_id = $value;
                                    $model_ss->save();
                                }
                            }
                        }
                    }
                }
            }
            Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
            $this->refresh();
        }



        $all_sellers = ScoringSeller::model()->findAllByAttributes(array('scoring_id' => $model->id));
        $all_sellers_list = CHtml::listData($all_sellers, 'id', 'user_id');

        $team_name = TeamName::model()->findAll();

        $string = '';
        foreach ($team_name as $key => $value) {
            $string .= '<optgroup label="' . $value->title . '">';
            $sellers = Team::model()->findAllByAttributes(array('team_name_id' => $value->id));
            foreach ($sellers as $key2 => $value2) {
                $selected = FALSE;
                if (in_array($value2->user_id, $all_sellers_list)) {
                    $selected = TRUE;
                }
                if ($selected) {
                    $string .= '<option value="' . $value2->user_id . '" selected="selected">';
                } else {
                    $string .= '<option value="' . $value2->user_id . '">';
                }

                $string .= $value2->user->name . ' (' . $value2->getAllStoreFilters($id) . ')';
                $string .= '</option>';
            }
            $string .= '</optgroup>';
        }


        $this->render('add_team', array(
            'model' => $model,
            'string' => $string,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $cats = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $tags = ScoringTag::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $sellers = ScoringSeller::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $presentation_image = ScoringImage::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $description = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $upload_image = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $this->render('view', array(
            'model' => $model,
            'cats' => $cats,
            'tags' => $tags,
            'sellers' => $sellers,
            'presentation_image' => $presentation_image,
            'description' => $description,
            'upload_image' => $upload_image,
        ));
    }

    public function actionCreate() {
        $model = new Scoring;

        if (isset($_POST['Scoring'])) {
            $model->attributes = $_POST['Scoring'];
            if ($model->save())
                $this->redirect(array('add_store_category_tag', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionAdd_store_category_tag($id) {
        $model = $this->loadModel($id);

        $model_add_scoring_tag = new AddStoreTagForm;
        if (isset($_POST['AddStoreTagForm'])) {
            $model_add_scoring_tag->attributes = $_POST['AddStoreTagForm'];
            $model_add_scoring_tag->scoring_id = $model->id;
            // Del
            $all_sc = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $model->id));
            foreach ($all_sc as $key => $value) {
                $value->delete();
            }
            $all_st = ScoringTag::model()->findAllByAttributes(array('scoring_id' => $model->id));
            foreach ($all_st as $key => $value) {
                $value->delete();
            }
            // ****** END Del
            $is_array = is_array($model_add_scoring_tag->store_category);
            if ($is_array) {
                if (count($model_add_scoring_tag->store_category) > 0) {
                    foreach ($model_add_scoring_tag->store_category as $key => $value) {
                        $check_cat = StoreCategory::model()->findByPk($value);
                        if (!empty($check_cat)) {
                            $model_sc = ScoringCategory::model()->findByAttributes(array('scoring_id' => $model_add_scoring_tag->scoring_id, 'store_category_id' => $value));
                            if (empty($model_sc)) {
                                $model_sc = new ScoringCategory;
                                $model_sc->scoring_id = $model_add_scoring_tag->scoring_id;
                                $model_sc->store_category_id = $value;
                                $model_sc->save();
                            }
                        }
                    }
                }
            }
            // ******** 
            $is_array = is_array($model_add_scoring_tag->tags);
            if ($is_array) {
                if (count($model_add_scoring_tag->tags) > 0) {
                    foreach ($model_add_scoring_tag->tags as $key => $value) {
                        $check_tag = Tag::model()->findByPk($value);
                        if (!empty($check_tag)) {
                            $model_st = ScoringTag::model()->findByAttributes(array('scoring_id' => $model_add_scoring_tag->scoring_id, 'tag_id' => $value));
                            if (empty($model_st)) {
                                $model_st = new ScoringTag;
                                $model_st->scoring_id = $model_add_scoring_tag->scoring_id;
                                $model_st->tag_id = $value;
                                $model_st->save();
                            }
                        }
                    }
                }
            }

            Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
            $this->refresh();
//            $this->redirect(array('add_team', 'id' => $model->id));
        }
        //

        $all_sc = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $model->id));
        if (!empty($all_sc)) {
            $list_sc = CHtml::listData($all_sc, 'id', 'store_category_id');
            $model_add_scoring_tag->store_category = $list_sc;
        }

        $all_st = ScoringTag::model()->findAllByAttributes(array('scoring_id' => $model->id));
        if (!empty($all_st)) {
            $list_st = CHtml::listData($all_st, 'id', 'tag_id');
            $model_add_scoring_tag->tags = $list_st;
        }


        $this->render('add_store_category_tag', array(
            'model' => $model,
            'model_add_scoring_tag' => $model_add_scoring_tag,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Scoring'])) {
            $model->attributes = $_POST['Scoring'];
            if ($model->save()) {
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
                $this->refresh();
//                $this->redirect(array('add_store_category_tag', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionArchive($id) {
        $this->loadModel($id)->archive();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex() {
        $model = new Scoring('search');
        $model->unsetAttributes();
        if (isset($_GET['Scoring']))
            $model->attributes = $_GET['Scoring'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'scoring-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // ***************************
    public function actionExport_info($id) {
        $table_string = '<table class="table table-bordered">';
        $model = $this->loadModel($id);
        //
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_description = ScoringDescription::model()->resetScope()->findAll($criteria);
        //
        // ARTICLE
        //
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_articles = ArticlePoint::model()->resetScope()->findAll($criteria);
        //
        // ARTICLE
        //
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->order = 'position ASC';
        $scoring_images = ScoringImageUpload::model()->resetScope()->findAll($criteria);
        //        
        $table_string .= '<tr>';
        $table_string .= '<th>' . Yii::t("translation", "scoring_name") . ': ' . $model->title . '</th>';
        $table_string .= '<th></th><th></th><th></th><th></th>';

        foreach ($scoring_description as $key => $value) {
            $table_string .= '<th>' . CHtml::decode(trim($value->description)) . '</th>';
        }
        foreach ($scoring_articles as $key => $value) {
            $table_string .= '<th>' . CHtml::decode(trim($value->article->title)) . '</th>';
        }
        foreach ($scoring_images as $key => $value) {
            $table_string .= '<th>' . CHtml::decode(trim($value->description)) . '</th>';
        }
        $table_string .= '</tr>';
        //      
        $criteria = new CDbCriteria;
        $criteria->condition = 'scoring_id = :scoringID';
        $criteria->params = array(':scoringID' => $id);
        $criteria->select = 'id, store_id, percent, user_id';
        $all_stores = TotalScoring::model()->resetScope()->findAll($criteria);

        $main_url = 'www.' . $_SERVER['HTTP_HOST'] . '/upload_files/answer_upload/';

        foreach ($all_stores as $key => $value) {
            $table_string .= '<tr>';
            $model_user = User::model()->resetScope()->findByPk($value->user_id);
            $model_store = Store::model()->resetScope()->findByPk($value->store_id);
            //
            $table_string .= '<td>' . CHtml::decode(trim($model_store->storename)) . '</td>';
            $table_string .= '<td>' . CHtml::decode(trim($model_store->storeCategory->title)) . '</td>';
            $table_string .= '<td>' . CHtml::decode(trim($model_store->AllTagsForExport)) . '</td>';
            $table_string .= '<td>' . CHtml::decode(trim($model_user->name)) . '</td>';
            $table_string .= '<td>' . $value->percent . "%" . '</td>';
            //
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_description = AnswerDescription::model()->resetScope()->findAll($criteria);
            $answer_description_list = CHtml::listData($answer_description, 'scoring_description_id', 'answer');
            //
            foreach ($scoring_description as $key2 => $value2) {
                if (isset($answer_description_list[$value2->id])) {
                    $table_string .= '<td>' . $answer_description_list[$value2->id] . '</td>';
                } else {
                    $table_string .= '<td></td>';
                }
            }
            //
            // ARTICLE
            //
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_article = AnswerArticle::model()->resetScope()->findAll($criteria);
            $answer_article_list = CHtml::listData($answer_article, 'article_point_id', 'answer');
            //
            foreach ($scoring_articles as $key4 => $value4) {
                if (isset($answer_article_list[$value4->id])) {
                    $table_string .= '<td>' . $answer_article_list[$value4->id] . '</td>';
                } else {
                    $table_string .= '<td></td>';
                }
            }
            //
            // ARTICLE
            $criteria = new CDbCriteria;
            $criteria->condition = 'total_scoring_id = :totalScoringId AND user_id = :userID';
            $criteria->params = array(':totalScoringId' => $value->id, ':userID' => $value->user_id);
            $answer_upload = AnswerUpload::model()->resetScope()->findAll($criteria);
            $answer_upload_list = CHtml::listData($answer_upload, 'scoring_image_upload_id', 'image');
            //
            foreach ($scoring_images as $key3 => $value3) {
                if (isset($answer_upload_list[$value3->id])) {
                    $table_string .= '<td>' . $main_url . $answer_upload_list[$value3->id] . '</td>';
                } else {
                    $table_string .= '<td></td>';
                }
            }
            $table_string .= '</tr>';
        }
        $table_string .= '</table>';
        $this->render('export_info', array(
            'model' => $model,
            'table_string' => $table_string,
        ));
    }

    // ******************************

    public function actionAdd_article($id) {
        $model = $this->loadModel($id);

        // Фильтр 
        $model_checking = ArticleCheck::model()->findAllByAttributes(array('scoring_id' => $model->id));
        $model_checking_list = CHtml::listData($model_checking, 'article_id', 'article_id');
        //
        $models_scoring_cat = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $model->id));
        $sort_array = NULL;
        foreach ($models_scoring_cat as $key => $value) {
            $models_art_cat = ArtCat::model()->findAllByAttributes(array('store_category_id' => $value->store_category_id));
            foreach ($models_art_cat as $key_2 => $value_2) {
                if (isset($model_checking_list[$value_2->article_id])) {
                    $sort_array[$value_2->article_id] = $value_2;
                }
            }
        }

        $last_model = ArticlePoint::model()->last_position()->findByAttributes(array('scoring_id' => $model->id));

        if (isset($_POST['Add'])) {
            $add_array = $_POST['Add'];

            if (is_array($add_array) && !empty($add_array)) {

                $position = 0;
                $bool = FALSE;
                $models = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $model->id));
                //
                if (!empty($models)) {
                    foreach ($models as $key2 => $value2) {
                        $models2[$value2->id] = $value2->id;
                    }
                }

                foreach ($add_array as $key => $value) {
                    $num = 0;
                    if (isset($value['num'])) {
                        if ($value['num'] == 'on') {
                            $num = 1;
                        }
                    }

                    $bool_point = FALSE;

                    if (!empty($value['point'])) {
                        $bool_point = TRUE;
                    }

                    $model_scoring_article = ArticlePoint::model()->findByAttributes(array('scoring_id' => $model->id, 'article_id' => $value['article_id']));

                    if (empty($model_scoring_article)) {
                        $model_scoring_article = new ArticlePoint;
                        $model_scoring_article->scoring_id = $model->id;
                        $model_scoring_article->article_id = $value['article_id'];
                    } else {
                        if ($bool_point == FALSE) {
                            $model_scoring_article->delete();
                            continue;
                        }
                    }

                    if ($bool_point) {
                        $model_scoring_article->point = (int) $value['point'];
                    }

                    $model_scoring_article->num = $num;
                    $model_scoring_article->position = $position;

                    if ($model_scoring_article->save()) {
                        $bool = TRUE;
                        $position++;
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information_you_can_click_next"));
                    $this->refresh();
                }
            }
        }

        $models = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $model->id));

        $this->render('add_article', array(
            'model' => $model,
            'models' => $models,
            'last_model' => $last_model,
            'sort_array' => $sort_array,
            'models_scoring_cat' => $models_scoring_cat
        ));
    }

    // AJAX

    public function actionChangeAddArticle($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $bool = $model->add_article;
            if ($bool == 0) {
                $model->add_article = 1;
            } else {
                $model->add_article = 0;
            }
            if ($model->saveAttributes(array('add_article'))) {
//                echo 'good';
            } else {
//                echo 'error';
            }
        }
        Yii::app()->end();
    }

    public function actionArticle_check($id) {
        $model_scoring = $this->loadModel($id);

        // Фильтр 
        $models_scoring_cat = ScoringCategory::model()->findAllByAttributes(array('scoring_id' => $model_scoring->id));
        $sort_array = NULL;
        foreach ($models_scoring_cat as $key => $value) {
            $models_art_cat = ArtCat::model()->findAllByAttributes(array('store_category_id' => $value->store_category_id));
            foreach ($models_art_cat as $key_2 => $value_2) {
                $sort_array[$value_2->article_id] = $value_2->article_id;
            }
        }

        $model_article = new Article('search');
        $model_article->unsetAttributes();
        if (isset($_GET['Article']))
            $model_article->attributes = $_GET['Article'];

        if (isset($_POST['yt0']) || isset($_POST['yt1'])) {
            $bool = FALSE;
            if (isset($_POST['selectedIds'])) {
                $array_check = $_POST['selectedIds'];
                foreach ($array_check as $key => $value) {
                    $value = (int) $value;
                    $check = ArticleCheck::model()->findByAttributes(array('scoring_id' => $id, 'article_id' => $value));
                    if (empty($check)) {
                        $check = new ArticleCheck;
                        $check->scoring_id = $id;
                        $check->article_id = $value;
                        if ($check->save()) {
                            $bool = TRUE;
                        }
                    }
                }

                $model_check = ArticleCheck::model()->findAllByAttributes(array('scoring_id' => $id));
                foreach ($model_check as $k => $v) {
                    if (in_array($v->article_id, $array_check)) {
                        
                    } else {
                        if ($v->delete()) {
                            $bool = TRUE;
                        }
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information"));
                }
                $this->redirect(array('scoring/add_article', 'id' => $id));
            } else {
                $model_check = ArticleCheck::model()->findAllByAttributes(array('scoring_id' => $id));
                foreach ($model_check as $key => $v) {
                    if ($v->delete()) {
                        $bool = TRUE;
                    }
                }
                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_save_information"));
                }
                $this->redirect(array('scoring/add_article', 'id' => $id));
            }
        }


        $this->render('article_check', array(
            'model_article' => $model_article,
            'model_scoring' => $model_scoring,
            'sort_array' => $sort_array,
        ));
    }

}
