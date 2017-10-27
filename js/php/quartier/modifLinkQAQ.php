<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');
$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');
$idLink=\filter_input(INPUT_GET,'idLinkQA');
$newAQ=\filter_input(INPUT_GET,'newAQ');

$sql="UPDATE z_agent_quartier SET id_user=:idU WHERE id=:idLink";
$req=$pdo->prepare($sql);
$req->bindValue('idU',$newAQ, PDO::PARAM_INT);
$req->bindValue('idLink',$idLink, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();