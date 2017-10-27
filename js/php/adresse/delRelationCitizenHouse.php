<?php

include('../autoload.php');

$idPB=\filter_input(INPUT_GET, 'idPB');
$user=\filter_input(INPUT_GET, 'user');

if(isset($idPB)){
    $req=$pdoH->prepare('UPDATE Hestia_Pers_Bat SET Actif="N", DateOut=NOW(), id_Out=:user WHERE id=:idRow');
    $req->bindValue('user',$user,  PDO::PARAM_INT);
    $req->bindValue('idRow',$idPB,  PDO::PARAM_INT);
    $req->execute();
    echo $req->rowCount();
}