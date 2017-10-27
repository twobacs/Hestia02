<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Rue{
    private $pdo;
    
    public function __construct($dbPdo){
        $this->pdo=$dbPdo;
    }
    
    public function getRues(){
        $sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues ORDER BY NomRue';
        $req=$this->pdo->query($sql);
        return $req;
    }
}