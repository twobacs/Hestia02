<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */
class Historique{

private $pdo;

    public function __construct($dbPdo) {
  	$this->pdo=$dbPdo;        
    }

public function addEntry($get){
    $sql='SELECT nom, prenom FROM users WHERE id_user=:idUser';
    $reqa=$this->pdo->prepare($sql);
    $reqa->bindValue('idUser',$get['user'], PDO::PARAM_INT);
    $reqa->execute();
    foreach($reqa as $row){
        $nom=$row['nom'];
        $prenom=$row['prenom'];
    }    
    $sql='INSERT INTO Hestia_complete_history (id_user, nom, prenom, component, action, url, date, f_table, type_action, f_key) VALUES'
        . '(:user, :nom, :prenom, :component, :action, :url, NOW(), :ftable, :typeA, :fkey)';
    $req=$this->pdo->prepare($sql);
    $req->bindValue('user',$get['user'],  PDO::PARAM_INT);
    $req->bindValue('nom',$nom,  PDO::PARAM_STR);
    $req->bindValue('prenom',$prenom,  PDO::PARAM_STR);
    $req->bindValue('component',$get['component'],  PDO::PARAM_STR);
    $req->bindValue('action', htmlentities($get['action']),  PDO::PARAM_STR);
    $req->bindValue('url', htmlentities($get['url']),  PDO::PARAM_STR);
    $req->bindValue('ftable',$get['table'],PDO::PARAM_STR);
    $req->bindValue('typeA',$get['typeA'],PDO::PARAM_STR);
    $req->bindValue('fkey',$get['fkey'],PDO::PARAM_STR);
    $req->execute();
    return $req->rowCount();
}

}
