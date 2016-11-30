<?php

class Controller extends CController {

    public function init() {
        $mystring = Yii::app()->request->requestUri;
        $findme = 'site/logout';
        $pos = strpos($mystring, $findme);

        if ($pos === false) {
            if (Yii::app()->user->checkAccess('administrator')) {
                $this->redirect('/admin');
            }
            if (Yii::app()->user->checkAccess('customer')) {
                $this->redirect('/customer');
            }
        } else {
            
        }

      


        parent::init();
    }

    public $layout = '//layouts/column1';
    public $menu = array();
    public $breadcrumbs = array();

}
