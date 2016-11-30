<?php

class MenuForms extends CWidget {

    public $scoring_model;
    public $model;

    public function run() {       

        $this->render('index', array('scoring_model' => $this->scoring_model, 'model' => $this->model));
    }

}
