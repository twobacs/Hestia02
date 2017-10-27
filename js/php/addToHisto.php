<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

/*$idUser=\filter_input(INPUT_GET, 'user');

$action=\filter_input(INPUT_GET, 'action');
$details=\filter_input(INPUT_GET, 'details');
$table=\filter_input(INPUT_GET, 'table');
$field=\filter_input(INPUT_GET, 'field');        
$id_table=\filter_input(INPUT_GET, 'idTable');
$url=\filter_input(INPUT_GET, 'url');*/

include('autoload.php');


/*$sql='INSERT INTO histo_action (id_user, action, field, id_fk, details, ftable, date) VALUES (:user, :action, :field, :fk, :details, :ftable, NOW())';
$req=$pdoH->prepare($sql);
$req->bindValue('user',$idUser,  PDO::PARAM_INT);
$req->bindValue('action', htmlentities($action),  PDO::PARAM_STR);
$req->bindValue('details', htmlentities($details),  PDO::PARAM_STR);
$req->bindValue('field',$field,PDO::PARAM_STR);
$req->bindValue('fk',$id_table,PDO::PARAM_STR);
$req->bindParam('ftable',$table,PDO::PARAM_STR);
$req->execute();

$sql='SELECT nom, prenom FROM users WHERE id_user=:idUser';
$req=$pdoU->prepare($sql);
$req->bindValue('idUser',$idUser, PDO::PARAM_INT);
$req->execute();
foreach($req as $row){
    $nom=$row['nom'];
    $prenom=$row['prenom'];
}

$sql='INSERT INTO complete_history (id_user, nom, prenom, module, action, url, date, heure, f_table, type_action, f_key) VALUES'
        . '(:user, :nom, :prenom, :module, :action, :url, :date, :heure, :ftable, :typeA, :fkey)';*/

$histo = new Historique($pdoU,$pdoH);
echo $histo->addEntry($_GET);