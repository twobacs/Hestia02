<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$FR=\filter_input(INPUT_GET,'FR');
$NL=\filter_input(INPUT_GET,'NL');

include('../autoload.php');

$sql="INSERT INTO z_rues (NomRue, StraatNaam) VALUES (:Fra, :Nll)";
$req=$pdo->prepare($sql);
$req->bindValue('Fra', strtoupper($FR),PDO::PARAM_STR);
$req->bindValue('Nll', strtoupper($NL),PDO::PARAM_STR);
$req->execute();
//return $req->rowCount();
//echo $NL;