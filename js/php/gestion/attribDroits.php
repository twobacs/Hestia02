<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$niv=\filter_input(INPUT_GET, 'niv');
$idUser=\filter_input(INPUT_GET, 'idUser');

if(isset($niv)){
    include('../autoload.php');
    $sql='UPDATE Hestia_Acces SET acces=:niv WHERE id_user=:idUser';
    $req=$pdo->prepare($sql);
    $req->bindValue('niv',$niv,PDO::PARAM_INT);
    $req->bindValue('idUser',$idUser,PDO::PARAM_INT);
    $req->execute();
    $count=$req->rowCount();
    if($count==0){
        $sql='INSERT INTO Hestia_Acces (id_user, acces) VALUES (:idUser,:niv)';
        $req=$pdo->prepare($sql);
        $req->bindValue('niv',$niv,PDO::PARAM_INT);
        $req->bindValue('idUser',$idUser,PDO::PARAM_INT);
        $req->execute();
        $count=$req->rowCount();
    }
    echo $req->rowCount();
}