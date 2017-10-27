<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idBat= \filter_input(INPUT_GET, 'idBat');
$idPers= \filter_input(INPUT_GET, 'idPers');
$idUser= \filter_input(INPUT_GET, 'idUser');

include ('../autoload.php');

$sql='INSERT INTO Hestia_Pers_Bat (id_pers, id_Bat, actif, id_rel, DateIn, id_In) VALUES '
        . '(:idPers, :idBat, "O", "1", NOW(), :idUser)';
$req=$pdo->prepare($sql);
$req->bindValue('idPers',$idPers,  PDO::PARAM_INT);
$req->bindValue('idBat',$idBat,  PDO::PARAM_INT);
$req->bindValue('idUser',$idUser, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();