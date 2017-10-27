<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idStreet=\filter_input(INPUT_GET,'idStreet');
$nom=\filter_input(INPUT_GET,'nom');
$naam=\filter_input(INPUT_GET,'naam');

include ('../autoload.php');

$sql="UPDATE z_rues SET NomRue=:nom, StraatNaam=:naam WHERE IdRue=:idStreet";
$req=$pdo->prepare($sql);
$req->bindValue('nom', strtoupper($nom), PDO::PARAM_STR);
$req->bindValue('naam', strtoupper($naam), PDO::PARAM_STR);
$req->bindValue('idStreet',$idStreet, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();