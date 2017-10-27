<?php

class CEncodage extends CBase {

    public function __construct($appli) {
        parent::__construct($appli);
    }

public function homepage(){
	$coUsers=$this->model->test();
	$coHestia=$this->model->testHestia();
	$this->view->formIdentification($coUsers,$coHestia);
}
}
?>