<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');
$newQ=\filter_input(INPUT_GET,'newQ');
$newAQ=\filter_input(INPUT_GET,'newAQ');

$sql='INSERT INTO z_agent_quartier (id_quartier, id_user) VALUES (:idQ, :idAQ)';
$req=$pdo->prepare($sql);
$req->bindValue('idQ',$newQ, PDO::PARAM_INT);
$req->bindValue('idAQ',$newAQ, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();