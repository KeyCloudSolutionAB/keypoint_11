<?php

class StoreController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'add'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionAdd() {
        $model = new Store;

        $model->sellers = Yii::app()->user->name;

        if (isset($_POST['Store'])) {
            $model->attributes = $_POST['Store'];


            if ($model->validate()) {
                $bool1 = FALSE;
                $bool2 = FALSE;
                $bool3 = FALSE;
                if ($model->save()) {
                    $bool1 = TRUE;
                }
//                if ($model->saveAttributes(array('adress', 'zip', 'phone', 'email', 'note', 'city'))) {
//                    $bool1 = TRUE;
//                }

                if (!empty($_POST['Store']['sellers'])) {
                    $seller_id = Yii::app()->user->id;

                    if ($model->saveSeller($seller_id)) {
                        $bool2 = TRUE;
                    }
                }
                if (!empty($_POST['Store']['tags'])) {
                    $array_tags = $_POST['Store']['tags'];
                    foreach ($array_tags as $key => $value) {
                        $value = (int) $value;
                        $tag = StoreTag::model()->findByAttributes(array('store_id' => $model->id, 'tag_id' => $value));
                        if (empty($tag)) {
                            $tag = new StoreTag;
                            $tag->store_id = $model->id;
                            $tag->tag_id = $value;
                            if ($tag->save()) {
                                $bool3 = TRUE;
                            }
                        }
                    }

                    if (!empty($have_array_tags)) {
                        foreach ($have_array_tags as $key => $value) {
                            $check_key = array_search($value, $array_tags);
                            if ($check_key === FALSE) {
                                $tag = StoreTag::model()->findByAttributes(array('store_id' => $model->id, 'tag_id' => $value));
                                if (!empty($tag)) {
                                    $tag->delete();
                                }
                            }
                        }
                    }
                } else {
                    if (!empty($have_array_tags)) {
                        foreach ($have_array_tags as $key => $value) {
                            $tag = StoreTag::model()->findByAttributes(array('store_id' => $model->id, 'tag_id' => $value));
                            if (!empty($tag)) {
                                $tag->delete();
                            }
                        }
                    }
                }

                if ($bool1 || $bool2 || $bool3) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_add_store"));
                    $this->refresh();
                }
            }
        }

        $this->render('add', array('model' => $model));
    }

    public function actionIndex() {
        $this->redirect(array('site/index'));
    }

    public function actionView($id, $scoring) {
        $id = (int) $id;
        $scoring_id = (int) $scoring;
        //
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $scoring_id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $scoring_model = Scoring::model()->findByPk($scoring_id);
        if ($scoring_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $model = Store::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // Check Scoring & Store
        $check_ss = ScoringCategory::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_category_id' => $model->store_category_id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $model_total_scoring = TotalScoring::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_id' => $id, 'user_id' => Yii::app()->user->id));
        if (empty($model_total_scoring)) {
            $model_total_scoring = new TotalScoring;
            $model_total_scoring->scoring_id = $scoring_id;
            $model_total_scoring->store_id = $id;
            $model_total_scoring->percent = 0;
            if ($model_total_scoring->save()) {
                
            }
        }



        // all_descriptions
        $models = ScoringDescription::model()->findAllByAttributes(array('scoring_id' => $scoring_id));
        if (empty($models)) {
            $models_articles = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $scoring_id));
            if (!empty($models_articles)) {
                $this->redirect(array('scoring/articles', 'id' => $scoring_id, 'store' => $model->id));
            } else {
//                $this->redirect(array('scoring/note', 'id' => $scoring_id, 'store' => $model->id));
            }
        }

        if (isset($_POST['save'])) {

            if (isset($_POST['Choice'])) {
                $array = $_POST['Choice'];
                $models2 = NULL;
                foreach ($models as $key => $value) {
                    $models2[$value->id] = NULL;
                }

                if (!empty($models2)) {
                    foreach ($models2 as $key => $value) {
                        $check_array = array_key_exists($key, $array);
                        $model_number = ScoringDescription::model()->findByAttributes(array('id' => $key, 'num' => 1));
                        if ($check_array) {
                            $check_new_model = AnswerDescription::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id, 'scoring_description_id' => $key));
                            if (empty($check_new_model)) {
                                $new_model = new AnswerDescription;
                                $new_model->total_scoring_id = $model_total_scoring->id;
                                if (!empty($model_number)) {
                                    $new_model->answer_num = $array[$key];
                                    if ($new_model->answer_num == NULL) {
                                        $new_model->answer = 0;
                                    } else {
                                        $new_model->answer = 1;
                                    }
                                } else {
                                    $new_model->answer = 1;
                                }
                                $new_model->scoring_description_id = $key;
                                $new_model->save();
                            } else {
                                if (!empty($model_number)) {
                                    $check_new_model->answer_num = $array[$key];
                                    if ($check_new_model->answer_num == NULL) {
                                        $check_new_model->answer = 0;
                                    } else {
                                        $check_new_model->answer = 1;
                                    }
                                } else {
                                    $check_new_model->answer = 1;
                                }
                                $check_new_model->save();
                            }
                        } else {
                            $check_new_model = AnswerDescription::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id, 'scoring_description_id' => $key));
                            if (empty($check_new_model)) {
                                $new_model = new AnswerDescription;
                                $new_model->total_scoring_id = $model_total_scoring->id;
                                if (!empty($model_number)) {
                                    $new_model->answer_num = $array[$key];
                                    if ($new_model->answer_num == NULL) {
                                        $new_model->answer = 0;
                                    } else {
                                        $new_model->answer = 1;
                                    }
                                } else {
                                    $new_model->answer = 0;
                                }
                                $new_model->scoring_description_id = $key;
                                $new_model->save();
                            } else {
                                if (!empty($model_number)) {
                                    $check_new_model->answer_num = $array[$key];
                                    if ($check_new_model->answer_num == NULL) {
                                        $check_new_model->answer = 0;
                                    } else {
                                        $check_new_model->answer = 1;
                                    }
                                } else {
                                    $check_new_model->answer = 0;
                                }
                                $check_new_model->save();
                            }
                        }
                        //
                    }
                }
            } else {
                $models2 = NULL;
                foreach ($models as $key => $value) {
                    $models2[$value->id] = NULL;
                }

                if (!empty($models2)) {
                    foreach ($models2 as $key => $value) {
                        $check_new_model = AnswerDescription::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id, 'scoring_description_id' => $key));
                        if (empty($check_new_model)) {
                            $new_model = new AnswerDescription;
                            $new_model->total_scoring_id = $model_total_scoring->id;
                            $new_model->answer = 0;
                            $new_model->scoring_description_id = $key;
                            $new_model->save();
                        } else {
                            $check_new_model->answer = 0;
                            $check_new_model->save();
                        }

                        //
                    }
                }
            }
            $percent = $model_total_scoring->changePercent();
            $model_total_scoring->date_update = new CDbExpression('NOW()');
            $model_total_scoring->saveAttributes(array('date_update'));
            Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
            $this->refresh();
        }

        // All AnswerDescription
        $all_answers = AnswerDescription::model()->findAllByAttributes(array('total_scoring_id' => $model_total_scoring->id));
        $array_all_answers = NULL;
        if (!empty($all_answers)) {
            foreach ($all_answers as $key3 => $value3) {
                $array_all_answers[$value3->scoring_description_id] = array(
                    'answer' => $value3->answer,
                    'answer_num' => $value3->answer_num,
                );
            }
        }

        $this->render('view', array(
            'model' => $model,
            'scoring_model' => $scoring_model,
            'models' => $models,
            'model_total_scoring' => $model_total_scoring,
            'array_all_answers' => $array_all_answers,
                )
        );
    }

}
