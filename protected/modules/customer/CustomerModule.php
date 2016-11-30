<?php

class CustomerModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'customer.models.*',
            'customer.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
