<?php

class Recent_activetyController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array('seller'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {     
        $recent_activety = TotalScoring::model()->SellerRecentActivety;      

        $this->render('index', array('total_scorings' => $recent_activety));
    }

}
