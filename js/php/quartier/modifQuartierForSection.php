<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');
$quartier=\filter_input(INPUT_GET,'quartier');
$idRowQR=\filter_input(INPUT_GET,'idRowQR');

$sql='UPDATE z_quartier_rue SET id_quartier=:idQ WHERE id=:id';
$req=$pdo->prepare($sql);
$req->bindValue('idQ',$quartier, PDO::PARAM_INT);
$req->bindValue('id',$idRowQR, PDO::PARAM_INT);
$req->execute();