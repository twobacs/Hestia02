<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');
$side=\filter_input(INPUT_GET,"side");
$idStreet=\filter_input(INPUT_GET,"idStreet");
$cote=\filter_input(INPUT_GET,"cote");
$row=\filter_input(INPUT_GET,"row");
$idRowLink=\filter_input(INPUT_GET,"idRowLink");
$value=\filter_input(INPUT_GET,"value");

if($side==='bas'){
    $sql='UPDATE z_quartier_rue SET limiteBas=:valeur WHERE id=:id';
}
else{
    $sql='UPDATE z_quartier_rue SET limiteHaut=:valeur WHERE id=:id';
}

$req=$pdo->prepare($sql);
$req->bindValue('valeur',$value, PDO::PARAM_STR);
$req->bindValue('id',$idRowLink, PDO::PARAM_INT);
$req->execute();
echo $req->rowCount();