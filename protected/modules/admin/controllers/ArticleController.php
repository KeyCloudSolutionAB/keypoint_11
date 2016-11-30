<?php

class ArticleController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'import',),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('create', 'update'),
                'roles' => array('administrator'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('administrator'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Article;

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $model = new Article('search');
        $model->unsetAttributes();
        if (isset($_GET['Article']))
            $model->attributes = $_GET['Article'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Article::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t("translation", "the_requested_page_does_not_exist"));
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'article-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // ****************************

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

                $data = NULL;
                $row = 0;
                if (($handle = fopen($file_name, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                        $num = count($data);
                        for ($c = 0; $c < $num; $c++) {
                            $arrResult[$row][] = $data[$c];
                        }
                        $row++;
                    }
                    fclose($handle);
                }


                if (@is_file($file_name))
                    @unlink($file_name);

                $bool = FALSE;



                foreach ($arrResult as $key => $value) {
                    if ($key == 0) {
                        if (!empty($value[0])) {
                            if ($value[0] != 'ART.NR SUPPLIER') {
                                Yii::app()->user->setFlash('error', Yii::t("translation", "file_is_not_template_file"));
                                $this->refresh();
                            }
                        }
                    } else {
                        $new_line = new ArticleImport;
                        if (!empty($value[0])) {
                            $new_line->article_id = CHtml::encode(trim($value[0]));
                        }
                        if (!empty($value[1])) {
                            $new_line->title = CHtml::encode(trim($value[1]));
                        }
                        if (!empty($value[2])) {
                            $new_line->cpg = CHtml::encode(trim($value[2]));
                        }
                        if (!empty($value[3])) {
                            $new_line->article_category = CHtml::encode(trim($value[3]));
                        }
                        if (!empty($value[4])) {
                            $new_line->ean = CHtml::encode(trim($value[4]));
                        }
                        if ($new_line->save()) {
                            $bool = TRUE;
                            set_time_limit(10);
                        }
                    }
                }

                if ($bool) {
                    Yii::app()->user->setFlash('good', Yii::t("translation", "successfully_import_file"));
                    // Save all category
                    $crit = new CDbCriteria;
                    $crit->distinct = true;
                    $crit->select = "article_category";
                    $article_import_article_category = ArticleImport::model()->findAll($crit);
                    foreach ($article_import_article_category as $value) {
                        $new_article_cat = new ArticleCategory;
                        $new_article_cat->title = $value['article_category'];
                        if ($new_article_cat->save()) {
                            set_time_limit(10);
                        }
                    }

                    $all_import_list = ArticleImport::model()->findAll();
                    foreach ($all_import_list as $key => $value) {
                        $new_article = new Article;
                        $model_article_category = ArticleCategory::model()->findByAttributes(array('title' => $value->article_category));
                        if (!empty($model_article_category)) {
                            $new_article->article_category_id = $model_article_category->id;
                        }

                        $new_article->article_id = $value->article_id;
                        $new_article->title = $value->title;
                        $new_article->cpg = $value->cpg;
                        $new_article->ean = $value->ean;

                        if ($new_article->save()) {
                            set_time_limit(10);
                        }
                    }

                    ArticleImport::model()->deleteAll();


                    $this->refresh();
                }
            }
        }

        $this->render('import', array('model' => $model));
    }

}
