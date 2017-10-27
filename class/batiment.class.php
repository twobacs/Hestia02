<?php

class Batiment{
    private $pdo;
    private $id;  
    public $id_commune;
    public $id_rue;
    public $Numero;
    public $Boite;
    public $ProbVentil='28';
    public $probElecGaz;
    public $ProbSanit;
    public $ProbChaufFixe;
    public $LogMult;
    public $Privacy;
    public $DetecFum;
    public $Surpop;
    public $ProbStab;
    public $ProbHumid;
    public $ProbChampi;
    public $ProbInadStructConcept;
    public $ProbEclaiNat;
    public $ProbCircu;
    
    public function __construct($dbPdo) {
        $this->pdo=$dbPdo;
    }
    
    /*function getFullInfosBatById(){
        
    }*/
    
    function getOwnerByIdBat($idBat){
        $sql='SELECT id_Pers FROM Hestia_Pers_Bat WHERE id_Bat=:bat AND id_Rel="1" AND Actif="O"';
        $req=$this->pdo->prepare($sql);
        $req->bindValue('bat',$idBat,  PDO::PARAM_INT);
        $req->execute();
        return $req;
    }    
}