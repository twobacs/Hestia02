<?php

class CUser extends CBase {

    public function __construct($appli) {
        parent::__construct($appli);
    }


public function connect(){
    $this->view->formConnect();
}

private function getPOST($p){
    return filter_input(INPUT_POST, $p);
}

public function login(){
    $data=$this->model->login($this->getPOST('login'), $this->getPOST('password'));
    if(is_array($data)){
        $this->view->menuAccueil($data);
    }
    else {
        $this->view->errorLog($data);
    }
}

public function retourAccueil(){
    if((isset($_SESSION['acces']))&&($_SESSION['acces']>'1')){
    $_SESSION['step']=0;
    $this->view->menuAccueil();
    }
    else{
     $this->view->nonDroit();
    }
}

public function gestPlateforme(){
    if((isset($_SESSION['acces']))&&($_SESSION['acces']>'9')){
//        Niveau 15 : complet : Chef de service quartier + secrétariat quartier + sur désignation chef de corps.
//        Niveau 10 : Antenne : Chefs d'antenne.
        $_SESSION['step']='gestPlateforme';
        $this->view->menuGestPlateforme($_SESSION['acces']);
    }
    else{
     $this->view->nonDroit();
    }
}

public function formEditUser(){
    $infosUser=$this->model->getInfosUserById(filter_input(INPUT_GET,'user'));
    $grades=$this->model->getGrades();
    $services=$this->model->getServices();
    $this->view->formEditUser($infosUser, $grades, $services, filter_input(INPUT_GET,'user'));
}

public function logoff(){
    $_SESSION['idUser']='';
    session_destroy();
    header('Location: index.php');
}

public function modifUser(){
    if((isset($_SESSION['acces']))&&($_SESSION['acces']>'9')){
        $acces=$_POST['acces'];
        $this->model->updateUser();
        //echo "<script>window.opener.location.reload(true);</script>";
        echo "<script>alert('Modifications enregistrées.\\nVeuillez cliquer sur \"Gestion des utilisateurs\" pour voir les changements');</script>";
        echo "<script>window.close();</script>";
    }
}

public function addUser(){
    $rep=$this->model->addUser();
    echo $rep;
    //$this->gestPlateforme('addOk');
}

}
?>
