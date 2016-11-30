<?php

class Controller extends CController {

    public $layout = '//layouts/column2';

    public function init() {
        if (!Yii::app()->user->checkAccess('customer')) {
            $this->redirect('/');
        }    

        parent::init();
    }

    public $menu = array();
    public $menu_right = array();
    public $breadcrumbs = array();

}
