<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idAntenne=\filter_input(INPUT_GET,'idAntenne');
$idQuartier=\filter_input(INPUT_GET,'idQuartier');
$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');

include ('../autoload.php');

$sql='UPDATE z_quartier SET id_antenne=:idAntenne WHERE id_quartier=:idQuartier';
$req=$pdo->prepare($sql);
$req->bindValue('idAntenne',$idAntenne,PDO::PARAM_INT);
$req->bindValue('idQuartier',$idQuartier,PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();
