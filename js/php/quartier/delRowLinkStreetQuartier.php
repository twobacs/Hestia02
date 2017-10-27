<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');
$idLink=\filter_input(INPUT_GET,'idLink');
$sql='DELETE FROM z_quartier_rue WHERE id=:idLink';
$req=$pdo->prepare($sql);
$req->bindValue('idLink',$idLink,PDO::PARAM_INT);
$req->execute();