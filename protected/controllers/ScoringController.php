<?php

class ScoringController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('image', 'index', 'note', 'upload_images', 'articles'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionImage($id, $store) {
        $scoring_id = (int) $id;
        $store_id = (int) $store;
        // check ScoringSeller
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $scoring_id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Scoring
        $scoring_model = Scoring::model()->findByPk($scoring_id);
        if ($scoring_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Store
        $store_model = Store::model()->findByPk($store_id);
        if ($store_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // 
        // all_image
        $models = ScoringImage::model()->findAllByAttributes(array('scoring_id' => $scoring_id));

        //
        $this->render('image', array('models' => $models, 'scoring_model' => $scoring_model, 'store_model' => $store_model));
    }

    public function actionIndex() {
        $this->redirect(array('site/index'));
    }

    public function actionNote($id, $store) {
        $scoring_id = (int) $id;
        $store_id = (int) $store;
        // check ScoringSeller
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $scoring_id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Scoring
        $scoring_model = Scoring::model()->findByPk($scoring_id);
        if ($scoring_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Store
        $store_model = Store::model()->findByPk($store_id);
        if ($store_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // 
        $model_total_scoring = TotalScoring::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_id' => $store_id, 'user_id' => Yii::app()->user->id));
        if (empty($model_total_scoring)) {
            $model_total_scoring = new TotalScoring;
            $model_total_scoring->scoring_id = $scoring_id;
            $model_total_scoring->store_id = $store_id;
            $model_total_scoring->percent = 0;
            if ($model_total_scoring->save()) {
                
            }
        }

        $model = AnswerNote::model()->findByAttributes(array('total_scoring_id' => $model_total_scoring->id));
        if (empty($model)) {
            $model = new AnswerNote;
        }

        if (isset($_POST['AnswerNote'])) {
            $model->note = CHtml::encode($_POST['AnswerNote']['note']);
            $model->total_scoring_id = $model_total_scoring->id;
            if ($model->save()) {
                $model_total_scoring->date_update = new CDbExpression('NOW()');
                $model_total_scoring->saveAttributes(array('date_update'));
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                $this->refresh();
            }
        }

        //      
        $this->render('note', array('scoring_model' => $scoring_model, 'store_model' => $store_model, 'model' => $model));
    }

    public function actionUpload_images($id, $store) {
        $scoring_id = (int) $id;
        $store_id = (int) $store;
        // check ScoringSeller
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $scoring_id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Scoring
        $scoring_model = Scoring::model()->findByPk($scoring_id);
        if ($scoring_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // check Store
        $store_model = Store::model()->findByPk($store_id);
        if ($store_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // 
        $model_total_scoring = TotalScoring::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_id' => $store_id, 'user_id' => Yii::app()->user->id));
        if (empty($model_total_scoring)) {
            $model_total_scoring = new TotalScoring;
            $model_total_scoring->scoring_id = $scoring_id;
            $model_total_scoring->store_id = $store_id;
            $model_total_scoring->percent = 0;
            if ($model_total_scoring->save()) {
                
            }
        }

        // all_images for upload
        $models = ScoringImageUpload::model()->findAllByAttributes(array('scoring_id' => $scoring_id));

        if (isset($_POST['add']) || isset($_FILES)) {
            $bool = FALSE;
            if (isset($_FILES)) {
                if (!empty($_FILES)) {
                    $files = $_FILES;
                    foreach ($models as $key => $value) {
                        $models2[$value->id] = NULL;
                    }
                    foreach ($files as $key => $value) {
                        $key = preg_replace("/[^0-9]/", '', $key);
                        $check_array = array_key_exists($key, $models2);
                        if ($check_array) {
                            $uploads_dir = Yii::app()->request->baseUrl . 'upload_files/answer_upload/';
                            foreach ($value['error'] as $key2 => $error) {
                                if ($error == 0) {
                                    $tmp_name = $value["tmp_name"][$key2];
                                    $uniq = uniqid();
                                    $format = preg_replace("/.*?\./", '', $value["name"][$key2]);
                                    $fileName = $uniq . '.' . $format;
                                    if (move_uploaded_file($tmp_name, $uploads_dir . $fileName)) {
                                        $model = new AnswerUpload('mysave');
                                        $model->image = $fileName;
                                        $model->total_scoring_id = $model_total_scoring->id;
                                        $model->scoring_image_upload_id = $key;
                                        // imageRotate
                                        $model->imageRotate($format, $uploads_dir . $fileName);
                                        if ($model->save()) {
                                            $thumb = Yii::app()->phpThumb->create($uploads_dir . $fileName);
                                            $thumb->resize(640, 480); // 640x480
                                            $thumb->save($uploads_dir . $fileName);
                                            $bool = TRUE;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($bool) {
                $percent = $model_total_scoring->changePercent();
                $model_total_scoring->date_update = new CDbExpression('NOW()');
                $model_total_scoring->saveAttributes(array('date_update'));
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                $this->refresh();
            }
        }

        if (isset($_GET['delete'])) {
            $delete_id = (int) $_GET['delete'];
            $delete_model = AnswerUpload::model()->findByPk($delete_id);
            if ($delete_model->delete()) {
                $percent = $model_total_scoring->changePercent();
                Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_delete"));
                $this->redirect(array('scoring/upload_images', 'id' => $scoring_model->id, 'store' => $store_model->id));
            }
        }

        $this->render('upload_images', array(
            'models' => $models,
            'scoring_model' => $scoring_model,
            'store_model' => $store_model,
            'model_total_scoring' => $model_total_scoring,
        ));
    }

    public function actionView() {
        $this->render('view');
    }

    // $id - это scoring_id \\ $store - это store_id
    public function actionArticles($id, $store) {
        $scoring_id = (int) $id;
        $store_id = (int) $store;
        //
        $for_check_model = ScoringSeller::model()->findByAttributes(array('scoring_id' => $scoring_id, 'user_id' => Yii::app()->user->id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $scoring_model = Scoring::model()->findByPk($scoring_id);
        if ($scoring_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $model = Store::model()->findByPk($store_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        // Check Scoring & Store
        $check_ss = ScoringCategory::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_category_id' => $model->store_category_id));
        if ($for_check_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $model_total_scoring = TotalScoring::model()->findByAttributes(array('scoring_id' => $scoring_id, 'store_id' => $store_id, 'user_id' => Yii::app()->user->id));
        if (empty($model_total_scoring)) {
            $model_total_scoring = new TotalScoring;
            $model_total_scoring->scoring_id = $scoring_id;
            $model_total_scoring->store_id = $store_id;
            $model_total_scoring->percent = 0;
            if ($model_total_scoring->save()) {
                
            }
        }
        // ***********
        $models = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $scoring_id));

        if (isset($_POST['Answer'])) {
            $array_answer = $_POST['Answer'];         
            foreach ($array_answer as $key => $value) {
                foreach ($value as $k => $v) {
                    $model_answer = AnswerArticle::model()->findByAttributes(array('total_scoring_id' => $v['total_scoring_id'], 'article_point_id' => $v['article_id']));
                    if (empty($model_answer)) {
                        $model_answer = new AnswerArticle;
                        $model_answer->total_scoring_id = $v['total_scoring_id'];
                        $model_answer->article_point_id = $v['article_id'];
                    }

                    if (isset($v['answer_num'])) {
                        $model_answer->answer_num = (int) $v['answer_num'];
                        if ($model_answer->answer_num == 0) {
                            $model_answer->answer = 0;
                            $model_answer->answer_num = NULL;
                        } else {
                            $model_answer->answer = 1;
                        }
                    } else {
                        if (isset($v['answer'])) {
                            if ($v['answer'] == 'on') {
                                $model_answer->answer = 1;
                            } else {
                                $model_answer->answer = 0;
                            }
                        } else {
                            $model_answer->answer = 0;
                        }
                    }
                    $model_answer->save();
                    $num = $k;
                    $num++;
                    if (empty($value[$num])) {
                        $model_total = TotalScoring::model()->findByPk($v['total_scoring_id']);
                        $model_total->changePercent();
                        $model_total->date_update = new CDbExpression('NOW()');
                        $model_total->saveAttributes(array('date_update'));
                    }
                }
            }
            Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
            $this->refresh();
        }

        $this->render('articles', array(
            'model' => $model,
            'scoring_model' => $scoring_model,
            'model_total_scoring' => $model_total_scoring,
            'models' => $models,
                )
        );
    }

}
