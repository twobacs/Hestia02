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

$sql='UPDATE z_quartier SET id_antenne="0" WHERE id_quartier=:idQuartier AND id_antenne=:idAntenne';
$req=$pdo->prepare($sql);
$req->bindValue('idQuartier',$idQuartier,  PDO::PARAM_INT);
$req->bindValue('idAntenne',$idAntenne, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();