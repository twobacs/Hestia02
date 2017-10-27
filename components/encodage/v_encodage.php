<?php

class VEncodage extends VBase {

    function __construct($appli, $model) {
        parent::__construct($appli, $model);
    }
	
public function formIdentification($a,$b){
	$this->appli->content=$a."<br />".$b;
}

}
?>