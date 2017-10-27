<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idQuartier= \filter_input(INPUT_GET, 'idQuartier');
$acces= \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');

include ('../autoload.php');

$sql='SELECT a.denomination, a.gsm, '
        . 'c.nom, c.prenom, c.id_user '
        . 'FROM z_quartier a '
        . 'LEFT JOIN z_agent_quartier b ON b.id_quartier = a.id_quartier '
        . 'LEFT JOIN users c ON c.id_user = b.id_user '
        . 'WHERE a.id_quartier=:idQuartier';
$req=$pdo->prepare($sql);
$req->bindValue('idQuartier',$idQuartier, PDO::PARAM_INT);
$req->execute();
foreach($req as $row){
    echo $row['nom'].' '.$row['prenom'];
}
//echo $sql;