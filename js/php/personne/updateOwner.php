<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');

$id=\filter_input(INPUT_GET, 'owner');
$data['Nom']=\filter_input(INPUT_GET, 'name');
$data['Prenom']=\filter_input(INPUT_GET, 'firstName');
$data['GSM']=\filter_input(INPUT_GET, 'mobile');
$data['CP']=\filter_input(INPUT_GET, 'zip');
$data['Ville']=\filter_input(INPUT_GET, 'city');
$data['Rue']=\filter_input(INPUT_GET, 'street');
$data['Num']=\filter_input(INPUT_GET, 'number');
$data['Bte']=\filter_input(INPUT_GET, 'box');

if(is_int((int)$data['Ville'])){
    $sql='SELECT name FROM cities WHERE id=:id';
    $req=$pdo->prepare($sql);
    $req->bindValue('id',$data['Ville'],  PDO::PARAM_INT);
    $req->execute();
    foreach($req as $row){
        $data['Ville']=$row['name'];
    }
}

if(is_int((int)$data['Rue'])){
    $sqla='SELECT NomRue FROM z_rues WHERE idRue=:id';
    $reqa=$pdo->prepare($sqla);
    $reqa->bindValue('id',$data['Rue'],  PDO::PARAM_INT);
    $reqa->execute();
    foreach($reqa as $rowa){
        $data['Rue']=$rowa['NomRue'];
    }
}

if(isset($id)){
    //include('../autoload.php');
    $personne=new Personne($pdo);
    echo $personne->updateById($id,$data);
    
}
//print_r($data);