<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idStreet=\filter_input(INPUT_GET,'idStreet');
$side=\filter_input(INPUT_GET,'side');
$lh=\filter_input(INPUT_GET,'limiteHaute');
$lb=\filter_input(INPUT_GET,'limiteBasse');
$newQ=\filter_input(INPUT_GET,'newQ');

include('../autoload.php');

$sql='INSERT INTO z_quartier_rue (id_quartier, IdRue, cote, limiteBas, limiteHaut) VALUES (:IdQuartier, :IdRue, :cote, :lb, :lh)';
$req=$pdo->prepare($sql);
$req->bindValue('IdQuartier',$newQ,PDO::PARAM_INT);
$req->bindValue('IdRue',$idStreet,PDO::PARAM_INT);
$req->bindValue('cote',$side, PDO::PARAM_STR);
$req->bindValue('lb',$lb, PDO::PARAM_STR);
$req->bindValue('lh',$lh, PDO::PARAM_STR);

$req->execute();

echo $req->rowCount();