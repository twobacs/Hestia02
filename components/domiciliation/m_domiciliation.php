<?php

class MDomiciliation extends MBase {

	private $checkDbPDO = false;

	public function __construct($appli) {
		parent::__construct($appli);
		
	}
        
private function getPOST($p){
    return filter_input(INPUT_POST, $p);
}

public function newDateRef(){
    $date=$this->getPOST('date');
    $number=$this->getPOST('number');
    $user=$_SESSION['idUser'];
    $quartier=$this->getPOST('idQuartier');
    $sql='SELECT COUNT(*) FROM Hestia_Ref_Domiciliation WHERE id_Admin=:refExt';
    $req=$this->appli->dbPdo->prepare($sql);
    $req->bindValue('refExt',$number,PDO::PARAM_STR);
    $req->execute();
    foreach ($req as $row){
        $count=$row['COUNT(*)'];
    }
    if($count>0) {return false;}
    else {
        $sql='INSERT INTO Hestia_Ref_Domiciliation (date_ville, id_Admin, date_Hestia, idUSer, id_quartier, last_modif) VALUES (:dateVille, :idAdmin, NOW(), :user, :quartier, NOW())';
        $req=$this->appli->dbPdo->prepare($sql);
        $req->bindValue('dateVille',$date,  PDO::PARAM_STR);
        $req->bindValue('idAdmin',$number,  PDO::PARAM_STR);
        $req->bindValue('user',$user,  PDO::PARAM_INT);
        $req->bindValue('quartier',$quartier,  PDO::PARAM_INT);
        $req->execute();
        $newRow=$this->dbPdo->lastInsertId();
        $_SESSION['idNewDom']=$newRow;
        return $newRow;}
}

public function getDomicileEnCours($idUser,$acces){
    if($acces==='5'){ //Agent de proximite
        //récupérer les données de la table Hestia_Ref_Domiciliation où date_cloture is_null pour l'agent s'identifiant
        $mesIdQuartier=$this->getMesIdQuartier($idUser);
        $idQ=array();
        $i=0;
        foreach ($mesIdQuartier as $row){
                $sqla='SELECT id, date_ville, id_Admin, date_Hestia, last_modif '
                        . 'FROM Hestia_Ref_Domiciliation '
                        . 'WHERE id_quartier=:idQ AND ISNULL(date_cloture)';
                $reqa=$this->appli->dbPdo->prepare($sqla);
                $reqa->bindValue('idQ',$row['id_quartier'],  PDO::PARAM_INT);
                $reqa->execute();
                $data['enCours']=$reqa->rowCount();
                if($data['enCours']>0){
                        foreach($reqa as $rowa){
                        $data[$i]['idTable']=$rowa['id'];
                        $data[$i]['date_ville']=$rowa['date_ville'];
                        $data[$i]['idAdmin']=$rowa['id_Admin'];
                        $data[$i]['dateHestia']=$rowa['date_Hestia'];
                        $data[$i]['lastModif']=$rowa['last_modif'];
                        $i++;
                    }
                }
            }
            $data['enCours']=$i;
            //echo '<br />';
           //print_r($data);
    }
    else if ($acces==='10'){ //Chef d'antenne
        //récupérer les données de la table Hestia_Ref_Domiciliation où date_cloture is_null pour les quartiers concernés par la ou les antenne(s)
    }
    else if ($acces==='15'){ //Dieu
        //récupérer toutes les données de la table Hestia_Ref_Domiciliation où date_cloture is_null
    }
    return $data;
}

public function getMesIdQuartier($idUser){
    //récupération de(s) id(s) quartier selon id_user dans z_agent_quartier
    //récupération des id_rues sur base des id_quartier récupérés
    //
    $sql='SELECT id_quartier FROM z_agent_quartier WHERE id_user=:idUser';
    $req=$this->appli->dbPdo->prepare($sql);
    $req->bindValue('idUser',$idUser,  PDO::PARAM_INT);
    $req->execute();
    return $req;
}

public function getRues(){
    include ('./class/rues.class.php');
    $rue = new Rue($this->appli->dbPdo);
    return $rue->getRues();
}

public function getQuartierByUser(){
    $sql='SELECT b.id_quartier, b.denomination '
            . 'FROM z_agent_quartier a '
            . 'LEFT JOIN z_quartier b ON b.id_quartier = a.id_quartier '
            . 'WHERE a.id_user=:idUser';
    $req=$this->appli->dbPdo->prepare($sql);
    $req->bindValue('idUser',$_SESSION['idUser'],PDO::PARAM_INT);
    $req->execute();
    //$reqb=$req;
    $data=array();
    $data['size']=$req->rowCount();
    $data['quartiers']=$req;
    if($data['size']=='1'){
        foreach($req as $row){
            $sqla='SELECT b.IdRue, b.NomRue, a.cote, a.limiteBas, a.limiteHaut FROM '
                    . 'z_quartier_rue a '
                    . 'LEFT JOIN z_rues b ON b.IdRue = a.IdRue '
                    . 'WHERE a.id_quartier=:idQuartier';
            $reqa=$this->appli->dbPdo->prepare($sqla);
            $reqa->bindValue('idQuartier',$row['id_quartier']);
            $reqa->execute();
            $data['rues']=$reqa;
            $data['denomination']=$row['denomination'];
            $data['id_quartier']=$row['id_quartier'];            
        }
    }
    return $data;
}
	
public function recStep1(){
    //Récupération des données de formulaire
    $CP=$this->getPOST('CP');
    $City=$this->getPOST('City');
    $Street=$this->getPOST('Street');
    $Nb=$this->getPOST('Number');
    $Bte=$this->getPOST('Bte');
    $Tel=$this->getPOST('Fixe');
    $Name=$this->getPOST('Name');
    $Surname=$this->getPOST('Surname');
    $Birth=$this->getPOST('Birth');
    $GSM=$this->getPOST('GSM');
    $Job=$this->getPOST('Job');
    $Empl=$this->getPOST('EmplCont');
    $Loc=$this->getPOST('Locataire');
    
}

}
?>
