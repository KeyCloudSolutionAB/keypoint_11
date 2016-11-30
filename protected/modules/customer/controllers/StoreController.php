<?php

class StoreController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
            'ajaxOnly + action',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'roles' => array('customer'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'import', 'action'),
                'roles' => array('customer'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('customer'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionAction() {
        $term = Yii::app()->getRequest()->getParam('act');

        if (empty($_POST['autoId'])) {
            Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest && $term) {

            switch ($term) {
                case '1':
                    echo 'ok 1';
                    Yii::app()->end();
                    $autoIdAll = $_POST['autoId'];
                    if (count($autoIdAll) > 0) {
                        foreach ($autoIdAll as $autoId) {
                            $model = $this->loadModel($autoId);
                            $model->status = 1;
                            if (empty($model->create_time)) {
                                $model->create_time = new CDbExpression('NOW()');
                            }
                            if ($model->save()) {
                                
                            } else {
                                throw new CHttpException(500, Yii::t("translation", "bad_request"));
                            }
                        }
                    }

                    break;

                case '2':
                    echo 'ok 2';
                    Yii::app()->end();
                    $autoIdAll = $_POST['autoId'];
                    if (count($autoIdAll) > 0) {
                        foreach ($autoIdAll as $autoId) {
                            $model = $this->loadModel($autoId);
                            $model->status = 2;
                            if (empty($model->create_time)) {
                                $model->create_time = new CDbExpression('NOW()');
                            }

                            if ($model->save()) {
                                
                            } else {
                                throw new CHttpException(500, Yii::t("translation", "bad_request"));
                            }
                        }
                    }

                    break;

                case '3':
                    echo 'ok 3';
                    Yii::app()->end();
                    $autoIdAll = $_POST['autoId'];
                    if (count($autoIdAll) > 0) {
                        foreach ($autoIdAll as $autoId) {
                            if ($this->loadModel($autoId)->delete()) {
                                
                            } else {
                                throw new CHttpException(500, Yii::t("translation", "bad_request"));
                            }
                        }
                    }

                    break;


                default:
                    throw new CHttpException(500, Yii::t("translation", "bad_request"));
//                    break;
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(500, Yii::t("translation", "bad_request"));
        }
    }

    public function actionImport() {
        $model = new StoreimportForm;

        if (isset($_POST['StoreimportForm'])) {
            $model->attributes = $_POST['StoreimportForm'];
            if ($model->validate()) {
                $model->file = CUploadedFile::getInstance($model, 'file');
                $sourceName = $model->file->getName();
                $sourcePath = pathinfo($sourceName);
                $file_name = 'upload_files/store_import/' . uniqid() . '.' . $sourcePath['extension'];
                $model->file->saveAs($file_name);
                //
                $arrResult = array();
                $arrLines = file($file_name);
                foreach ($arrLines as $line) {
                    $arrResult[] = explode(',', $line);
                }
                if (@is_file($file_name))
                    @unlink($file_name);
                $bool = FALSE;

                foreach ($arrResult as $key => $value) {
                    if ($key == 0) {
                        
                    } else {
                        $new_line = new StoreImport;
                        if (!empty($value[1])) {
                            $new_line->storename = CHtml::encode(trim($value[1]));
                        }
                        if (!empty($value[2])) {
                            $new_line->adress = CHtml::encode(trim($value[2]));
                        }
                        if (!empty($value[3])) {
                            $new_line->zip = CHtml::encode(trim($value[3]));
                        }
                        if (!empty($value[4])) {
                            $new_line->city = CHtml::encode(trim($value[4]));
                        }
                        if (!empty($value[5])) {
                            $new_line->phone = CHtml::encode(trim($value[5]));
                        }
                        if (!empty($value[6])) {
                            $new_line->store_category = CHtml::encode(trim($value[6]));
                        }
                        if (!empty($value[7])) {
                            $new_line->tag = CHtml::encode(trim($value[7]));
                        }
                        if (!empty($value[8])) {
                            $new_line->seller = CHtml::encode(trim($value[8]));
                        }
                        if (!empty($value[9])) {
                            $new_line->team = CHtml::encode(trim($value[9]));
                        }
                        if ($new_line->save()) {
                            $bool = TRUE;
                            set_time_limit(10);
                        }
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_import_file"));
                    // Save all team
                    $crit = new CDbCriteria;
                    $crit->distinct = true;
                    $crit->select = "team";
                    $store_import_store_category = StoreImport::model()->findAll($crit);
                    foreach ($store_import_store_category as $value) {
                        $new_team = new TeamName;
                        $new_team->title = $value['team'];
                        if ($new_team->save()) {
                            set_time_limit(10);
                        }
                    }


                    // Save all category
                    $crit = new CDbCriteria;
                    $crit->distinct = true;
                    $crit->select = "store_category";
                    $store_import_store_category = StoreImport::model()->findAll($crit);
                    foreach ($store_import_store_category as $value) {
                        $new_store_cat = new StoreCategory;
                        $new_store_cat->title = $value['store_category'];
                        if ($new_store_cat->save()) {
                            set_time_limit(10);
                        }
                    }

                    // Save all tag
                    $crit = new CDbCriteria;
                    $crit->distinct = true;
                    $crit->select = "tag";
                    $store_import_store_category = StoreImport::model()->findAll($crit);
                    foreach ($store_import_store_category as $value) {
                        $new_tag = new Tag;
                        $new_tag->title = $value['tag'];
                        if ($new_tag->save()) {
                            set_time_limit(10);
                        }
                    }

                    // Save all seller
                    $crit = new CDbCriteria;
                    $crit->distinct = true;
                    $crit->select = "seller";
                    $store_import_store_category = StoreImport::model()->findAll($crit);
                    foreach ($store_import_store_category as $value) {
                        $new_seller = new Seller('import_seller');
                        $new_seller->name = $value['seller'];
                        //
                        $store_import_one_seller = StoreImport::model()->findByAttributes(array('seller' => $new_seller->name));
                        if (!empty($store_import_one_seller)) {
                            $new_seller->team_name = $store_import_one_seller->team;
                        }
                        $uniqid = uniqid();
                        $email = $uniqid . '@mail.import';
                        $new_seller->email = $email;
                        $new_seller->password = $uniqid;
                        $new_seller->phone = '123456789';
                        $new_seller->status = 1;
                        if ($new_seller->save()) {
                            set_time_limit(10);
                        }
                    }

                    $all_import_list = StoreImport::model()->findAll();
                    foreach ($all_import_list as $key => $value) {
                        $new_store = new Store('import_store');
                        $model_store_category = StoreCategory::model()->findByAttributes(array('title' => $value->store_category));
                        if (!empty($model_store_category)) {
                            $new_store->store_category_id = $model_store_category->id;
                        }

                        $new_store->storename = $value->storename;
                        $new_store->adress = $value->adress;
                        $new_store->zip = $value->zip;
                        $new_store->phone = preg_replace("/[^0-9]/", '', $value->phone);
                        $new_store->status = 0;
                        $new_store->city = $value->city;
                        // Tag
                        $model_tag = Tag::model()->findByAttributes(array('title' => $value->tag));
                        if (!empty($model_tag)) {
                            $new_store->tags = $model_tag->id;
                        }

                        // Seller
                        $model_seller = Seller::model()->findByAttributes(array('name' => $value->seller));
                        if (!empty($model_seller)) {
                            $new_store->sellers = $model_seller->id;
                        }

                        if ($new_store->save()) {
                            set_time_limit(10);
                        }
                    }

                    StoreImport::model()->deleteAll();


                    $this->refresh();
                }
            }
        }

        $this->render('import', array('model' => $model));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Store;

        if (isset($_POST['Store'])) {
            $model->attributes = $_POST['Store'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Store'])) {
            $model->attributes = $_POST['Store'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $models = StoreTag::model()->findAllByAttributes(array('store_id' => $model->id));
        if (!empty($models)) {
            $array = NULL;
            foreach ($models as $key => $value) {
                $array[] = $value['tag_id'];
            }
            $model->tags = $array;
        }

        $models_sellers = StoreSeller::model()->findAllByAttributes(array('store_id' => $model->id));
        if (!empty($models_sellers)) {
            $array = NULL;
            foreach ($models_sellers as $key => $value) {
                $array[] = $value['user_id'];
            }
            $model->sellers = $array;
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

    public function actionIndex() {
        $model = new Store('search');
        $model->unsetAttributes();
        if (isset($_GET['Store']))
            $model->attributes = $_GET['Store'];

        //
        $store_model = new Store;
        if (isset($_POST['Store']) && isset($_POST['autoId'])) {
            $auto_id_all_array = $_POST['autoId'];
            if (count($auto_id_all_array) > 0) {
                $auto_id_all_bool = TRUE;
            } else {
                $auto_id_all_bool = FALSE;
            }

            if (!empty($_POST['add_tag']) && $auto_id_all_bool && !empty($_POST['tags_array'])) {
                $array_tags = $_POST['tags_array'];

                foreach ($auto_id_all_array as $key => $value) {
                    foreach ($array_tags as $key2 => $value2) {
                        $tag = Tag::model()->findByPk((int) $value2);
                        if (!empty($tag)) {
                            $tag_use = StoreTag::model()->findByAttributes(array('store_id' => $value, 'tag_id' => $value2));
                            if (empty($tag_use)) {
                                $model_store_tag = new StoreTag;
                                $model_store_tag->store_id = $value;
                                $model_store_tag->tag_id = $value2;
                                $model_store_tag->save();
                            }
                        }
                    }
                }
            }

            if (!empty($_POST['add_seller']) && $auto_id_all_bool && !empty($_POST['sellers_array'])) {
                $array_sellers = $_POST['sellers_array'];

                foreach ($auto_id_all_array as $key => $value) {
                    foreach ($array_sellers as $key2 => $value2) {
                        $seller = Seller::model()->findByPk((int) $value2);
                        if (!empty($seller)) {
                            $seller_use = StoreSeller::model()->findByAttributes(array('store_id' => $value, 'user_id' => $value2));
                            if (empty($seller_use)) {
                                $model_store_seller = new StoreSeller;
                                $model_store_seller->store_id = $value;
                                $model_store_seller->user_id = $value2;
                                $model_store_seller->save();
                            }
                        }
                    }
                }
            }

            Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_updated_information"));
            $this->refresh();
        }
        //
        $this->render('index', array(
            'model' => $model,
            'store_model' => $store_model,
        ));
    }

    public function loadModel($id) {
        $model = Store::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'store-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
