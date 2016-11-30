<?php

class Dashboard_shareController extends Controller {

    public function actionIndex($key_id) {
        $key = CHtml::encode($key_id);

        $model = $this->loadModel($key);

        $criteria = new CDbCriteria;
        $criteria->condition = "user_id='" . $model->customer_id . "' AND `status` = 0";
        $models = Scoring::model()->findAll($criteria);

        $total_scorings = TotalScoring::model()->getAdminRecentActivetyForShare($model->customer_id);

        $everage_mesured_store = FALSE;
        if (isset($_GET['everage_active'])) {
            if ($_GET['everage_active'] == 'yes') {
                $everage_mesured_store = TRUE;
            }
        }

        $this->render('index', array(
            'model' => $model,
            'models' => $models,
            'total_scorings' => $total_scorings,
            'everage_mesured_store' => $everage_mesured_store,
        ));
    }

    public function actionPossible($key_id, $id, $mesured = FALSE) {
        $key = CHtml::encode($key_id);
        $model_dash = $this->loadModel($key_id);
        $model = $this->loadModelScoring($id);
        if ($mesured) {
            $models = $model->MesuredStores;
        } else {
            $models = $model->PossibleStore2;
        }
//        $models = $model->PossibleStore2;
        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'attributes' => array(
                    'id',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));



        $this->render('possible', array(
            'model' => $model,
            'models' => $dataProvider,
            'model_dash' => $model_dash
        ));
    }

    public function actionMissing($key_id, $id) {
        $key = CHtml::encode($key_id);
        $model_dash = $this->loadModel($key_id);
        $model = $this->loadModelScoring($id);
        $models = $model->ListMissingStore;
        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'attributes' => array(
                    'id',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));



        $this->render('missing', array(
            'model' => $model,
            'models' => $dataProvider,
            'model_dash' => $model_dash
        ));
    }

    public function actionImage($key_id, $id) {
        $key = CHtml::encode($key_id);
        $model_dash = $this->loadModel($key_id);
        $model = $this->loadModelScoring($id);
        $models = $model->ImageStore;
        $this->render('image', array('model' => $model, 'models' => $models, 'model_dash' => $model_dash));
    }

    public function loadModel($key) {
        $model = Dashboard::model()->resetScope()->findByAttributes(array('key' => $key));

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function loadModelScoring($id) {
        $model = Scoring::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    // **** ( **** ) **** //

    public function actionTop($key_id, $id = NULL) {
        $key = CHtml::encode($key_id);
        $model_dash = $this->loadModel($key_id);

        if (!empty($id)) {
            $model = $this->loadModelScoring($id);
            if (!empty($model->id)) {
                $models = TotalScoring::model()->getShareTopSellers($model_dash->customer_id, $model->id);
            } else {
                $models = TotalScoring::model()->getShareTopSellers($model_dash->customer_id);
            }
        } else {
            $model = NULL;
            $models = TotalScoring::model()->getShareTopSellers($model_dash->customer_id);
        }

        $this->render('top', array('model' => $model, 'models' => $models, 'model_dash' => $model_dash));
    }

}
