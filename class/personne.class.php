<?php

class Personne{
    private $pdo;
    private $id;
    public $Nom;
    public $Prenom;
    public $DateNaissance;
    public $GSM;
    public $Profession;
    public $TelFixe;
    public $Locataire;
    public $Cle;
    public $Commentaire;
    public $id_PersEmp;
    public $CP;
    public $Ville;
    public $Rue;
    public $Num;
    public $Bte;

    public function __construct($dbPdo) {
        $this->pdo=$dbPdo;        
    }
    
    public function getInfosByIdPers($idR){
        $sql='SELECT a.id, a.Nom, a.Prenom, a.DateNaissance, '
                . 'a.GSM, a.Profession, a.TelFixe, a.Locataire, a.Cle, '
                . 'a.Commentaire, a.id_PersEmp, a.Pays, a.CP, a.Ville, a.Rue, a.Num, a.Bte '
                . 'FROM Hestia_Personne a WHERE a.id=:idOwner';
        $req=$this->pdoH->prepare($sql);
        $req->bindValue('idOwner',$idR,  PDO::PARAM_INT);
        $req->execute();
        return $req;
    }
    
    public function delRelationOwnerHouse($idHouse,$idOldOwner, $idUser){
        $sql='UPDATE Hestia_Pers_Bat SET Actif=:actif, DateOut=NOW(), id_Out=:user WHERE id_Pers=:oldOwner AND id_Bat=:building';
        $req=$this->pdoH->prepare($sql);
        $req->bindValue('actif',"N",  PDO::PARAM_STR);
        $req->bindValue('user',$idUser, PDO::PARAM_INT);
        $req->bindValue('oldOwner',$idOldOwner, PDO::PARAM_INT);
        $req->bindValue('building',$idHouse,  PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }
    
    public function updateById($id,$data){
        $field=array();
        $value=array();
        $sql='UPDATE Hestia_Personne SET ';
        $i=0;
        foreach($data as $key=>$val){
            $field[$i]=$key;
            $value[$i]=$val;            
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $sql.=($j===0) ? $field[$j].'="'.$value[$j].'"' : ', '.$field[$j].'="'.$value[$j].'"';
        }
        $sql.=' WHERE id=:id';        
        $req=$this->pdoH->prepare($sql);
        $req->bindValue('id',$id,  PDO::PARAM_INT);        
        $req->execute();        
        return $req->rowCount();
    }
    
    public function addOwnerToBat($get){
        $sql='SELECT * FROM Hestia_Personne WHERE Nom=:Nom AND Prenom=:Prenom';
        $req=$this->pdoH->prepare($sql);
        $req->bindValue('Nom',  strtoupper($get['Nom']),  PDO::PARAM_STR);
        $req->bindValue('Prenom',$get['Prenom'],  PDO::PARAM_STR);
        $req->execute();
        $count=$req->rowCount();
        if($count==0){
            $sql='INSERT INTO Hestia_Personne (Nom, Prenom, GSM, Pays, CP, Num, Bte, Ville, Rue) '
                    . 'VALUES (:Nom, :Prenom, :GSM, :Pays, :CP, :Num, :Bte, :Ville, :Rue)';
            $req= $this->pdoH->prepare($sql);
            $req->bindValue('Nom',$get['Nom'],  PDO::PARAM_STR);
            $req->bindValue('Prenom',$get['Prenom'], PDO::PARAM_STR);
            $req->bindValue('GSM',$get['GSM'],  PDO::PARAM_STR);
            $req->bindValue('Pays',$get['Pays'],  PDO::PARAM_STR);
            $req->bindValue('CP',$get['CP'],  PDO::PARAM_STR);
            $req->bindValue('Num',$get['Num'],  PDO::PARAM_STR);
            $req->bindValue('Bte',$get['Bte'],  PDO::PARAM_STR);
            $req->bindValue('Ville',$get['Ville'],  PDO::PARAM_STR);
            $req->bindValue('Rue',$get['Rue'],  PDO::PARAM_STR);
            $req->execute();
            $newId=$this->pdoH->lastInsertId();
            
            $sql='INSERT INTO Hestia_Pers_Bat (id_Pers, id_Bat, Actif, id_Rel, DateIn, id_In) '
                    . 'VALUES (:id_Pers, :id_Bat, "O", "1", NOW(), :id_In)';
            $req=$this->pdoH->prepare($sql);
            $req->bindValue('id_Pers',$newId,  PDO::PARAM_INT);
            $req->bindValue('id_Bat',$get['idBat'],  PDO::PARAM_INT);
            $req->bindValue('id_In',$get['idUser'],  PDO::PARAM_INT);
            $req->execute();
            return $req->rowCount();
        }
        else{
            return 0;
        }
        //$sql='INSERT INTO Personne () VALUES ()'
        //$req=$this->pdoH->prepare($sql);
        //$req->bindValue()        
    }

}