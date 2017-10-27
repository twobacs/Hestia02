<?php

/*
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');

$idAntenne= \filter_input(INPUT_GET, 'idAntenne');
$acces = \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');
$rue= \filter_input(INPUT_GET,'rue');
$num= \filter_input(INPUT_GET,'num');
$resp= \filter_input(INPUT_GET,'resp');
$tel= \filter_input(INPUT_GET,'tel');
$fax= \filter_input(INPUT_GET,'fax');


$sql='UPDATE z_antenne_quartier SET IdRue=:idrue, numero=:num, telephone=:tel, fax=:fax, id_resp=:idResp WHERE id_antenne=:idAntenne';
$req=$pdo->prepare($sql);
$req->bindValue('idrue',$rue,PDO::PARAM_INT);
$req->bindValue('num',$num,PDO::PARAM_STR);
$req->bindValue('tel',$tel,PDO::PARAM_STR);
$req->bindValue('fax',$fax,PDO::PARAM_STR);
$req->bindValue('idResp',$resp,PDO::PARAM_INT);
$req->bindValue('idAntenne',$idAntenne,PDO::PARAM_INT);
$req->execute();
