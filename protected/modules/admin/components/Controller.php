<?php

class Controller extends CController {

    public $layout = '//layouts/column2';

    public function init() {
        if (!Yii::app()->user->checkAccess('administrator')) {
            $this->redirect('/');
        }

        $choose_customer = AdminChoose::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
        if (!empty($choose_customer)) {
            Yii::app()->params['choose_customer'] = $choose_customer->customer_id;
        } else {
            Yii::app()->user->setFlash('globalerror', Yii::t("translation", "you_need_to_choose_customer"));
        }


        parent::init();
    }

    public $menu = array();
    public $menu_right = array();
    public $breadcrumbs = array();

}
