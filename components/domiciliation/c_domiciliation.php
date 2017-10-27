<?php
class CDomiciliation extends CBase {

    public function __construct($appli) {
        parent::__construct($appli);
    }


public function newDomicile(){
    //Propose à l'utilisateur le premier écran d'enregistrement d'une nouvelle domiciliation    
    if((isset($_SESSION['idUser']))&&(isset($_SESSION['acces']))&&($_SESSION['acces']>1)){
        $data=$this->model->newDateRef();
	$this->getFormAddDateRef();
    }
    else{
        $this->view->error(ERROR_DROITS);
    }
}

public function getFormAddDateRef() {
    if((isset($_SESSION['idUser']))&&(isset($_SESSION['acces']))&&($_SESSION['acces']>1)){
        $data=$this->model->getDomicileEnCours($_SESSION['idUser'],$_SESSION['acces']);
        $rues=$this->model->getRues();
        $quartierByUser=$this->model->getQuartierByUser();
        $this->view->getFormAddDateRef($_SESSION['idUser'],$data,$rues,$quartierByUser);
    }
    else{
        $this->view->error(ERROR_DECO);
    }
}


public function goStep1(){
    $_SESSION['step']=1;
    $this->view->menuNewDomicileStep1();
}
/*$_SESSION['step']=1;
	$this->view->menuNewDomicileStep1($data);*/
        
//Phase d'enregistrement du premier écran d'une nouvelle domiciliation (Adresse et chef de ménage)
//Si la case "Locataire -> oui" est cochée, renvoyer vers l'écran de saisie propriétaire après 
//vérification si le propriétaire de l'habitation n'est pas déjà renseigné lors d'une précédente domiciliation
//Si la case "Locataire -> non" est cochée, renvoyer vers l'écran d'information du propriétaire encodé et 
//demander validation ou modification des données
public function recStep1(){
    if((isset($_SESSION['idUser']))&&(isset($_SESSION['acces']))&&($_SESSION['acces']==15)){
        $this->model->recStep1();
    }
}
}
?>