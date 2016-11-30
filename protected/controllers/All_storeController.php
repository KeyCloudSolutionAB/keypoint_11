<?php

class All_storeController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'team', 'article', 'articles'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        if (isset($_GET['q'])) {
            $q = CHtml::encode($_GET['q']);
            if (!empty($q)) {
                $my_all_stores = StoreSeller::model()->getMyStores($q);
            } else {
                $my_all_stores = StoreSeller::model()->MyStores;
            }
        } else {
            $my_all_stores = StoreSeller::model()->MyStores;
        }

        $this->render('index', array('all_stores' => $my_all_stores));
    }

    public function actionTeam() {

        $all_my_team_users = User::model()->MyTeamUsers;

        if (isset($_GET['q'])) {
            $q = CHtml::encode($_GET['q']);
            if (!empty($q)) {
                $my_team_stores = StoreSeller::model()->getMyTeamStores($all_my_team_users, $q);
            } else {
                $my_team_stores = StoreSeller::model()->getMyTeamStores($all_my_team_users);
            }
        } else {
            $my_team_stores = StoreSeller::model()->getMyTeamStores($all_my_team_users);
        }



        $this->render('team', array('all_stores' => $my_team_stores));
    }

    public function actionView($id) {
        $model = Store::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $for_check_model = StoreSeller::model()->findByAttributes(array('store_id' => $id, 'user_id' => Yii::app()->user->id));

        $team_sellers = $model->TeamSellers;
        $bool_check = FALSE;

        if ($for_check_model == null) {
            foreach ($team_sellers as $key => $value) {
                $for_check_model = StoreSeller::model()->findByAttributes(array('store_id' => $id, 'user_id' => $key));
                if (!empty($for_check_model)) {
                    $bool_check = TRUE;
                    break;
                }
            }
        } else {
            $bool_check = TRUE;
        }

        if (!$bool_check) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }



        $models = StoreTag::model()->findAllByAttributes(array('store_id' => $model->id));
        if (!empty($models)) {
            $array = NULL;
            foreach ($models as $key => $value) {
                $array[] = $value['tag_id'];
            }
            $model->tags = $array;
            $have_array_tags = $array;
        }




        if (isset($_POST['Store'])) {
            $model->attributes = $_POST['Store'];
            if ($model->validate()) {
                $bool1 = FALSE;
                $bool2 = FALSE;
                $bool3 = FALSE;
                if ($model->saveAttributes(array('adress', 'zip', 'phone', 'email', 'note', 'city'))) {
                    $bool1 = TRUE;
                }

                if (!empty($_POST['Store']['sellers'])) {
                    $seller_id = (int) $_POST['Store']['sellers'];

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
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
                    $this->redirect(array('all_store/index'));
                }
            }
        }



        $models_sellers = StoreSeller::model()->findAllByAttributes(array('store_id' => $model->id));
        if (!empty($models_sellers)) {
            $array = NULL;
            foreach ($models_sellers as $key => $value) {
                $array[] = $value['user_id'];
            }
            $model->sellers = $array;
        }



        $this->render('view', array('model' => $model));
    }

    public function actionArticle() {

        if (isset($_GET['q'])) {
            $q = CHtml::encode($_GET['q']);
            if (!empty($q)) {
                $my_all_stores = StoreSeller::model()->getMyStores($q);
            } else {
                $my_all_stores = StoreSeller::model()->MyStores;
            }
        } else {
            $my_all_stores = StoreSeller::model()->MyStores;
        }

        $this->render('article', array('all_stores' => $my_all_stores));
    }

    public function actionArticles($id_store) {
        $id_store = (int) $id_store;
        $model = StoreSeller::model()->findAllByAttributes(array('store_id' => $id_store, 'user_id' => Yii::app()->user->id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model_store = Store::model()->findByPk($id_store);
        if ($model_store === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        $store_category_id = $model_store->store_category_id;
        // Взяли все scoring_id
        $all_scoringid = ArtCat::model()->getScoringCats($store_category_id);
        $check_scoringid = array();
        if (is_array($all_scoringid)) {
            foreach ($all_scoringid as $key => $value) {
                $check_array = ScoringSeller::model()->findByAttributes(array('scoring_id' => $value, 'user_id' => Yii::app()->user->id));
                if (!empty($check_array)) {
                    $check_scoringid[] = $check_array->scoring_id;
                }
            }
        }


        foreach ($check_scoringid as $key => $value) {
            $model_total_scoring = TotalScoring::model()->findByAttributes(array('scoring_id' => $value, 'store_id' => $id_store, 'user_id' => Yii::app()->user->id));
            if (empty($model_total_scoring)) {
                $model_total_scoring = new TotalScoring;
                $model_total_scoring->scoring_id = $value;
                $model_total_scoring->store_id = $id_store;
                $model_total_scoring->percent = 0;
                if ($model_total_scoring->save()) {
                    
                }
            }
        }

        $all_total = TotalScoring::model()->findAllByAttributes(array('store_id' => $id_store, 'user_id' => Yii::app()->user->id));
        $array = array();
        if (is_array($all_total)) {
            foreach ($all_total as $key => $value) {
                $all_article = ArticlePoint::model()->findAllByAttributes(array('scoring_id' => $value->scoring_id));
                $array[$value->scoring_id] = $all_article;
            }
        }

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

        $this->render('articles', array('array' => $array, 'store_category_id' => $store_category_id, 'store_id' => $id_store));
    }

}
