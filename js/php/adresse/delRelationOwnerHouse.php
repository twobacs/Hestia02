<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idBat=\filter_input(INPUT_GET, 'idBat');
$idOldOwner=\filter_input(INPUT_GET, 'idOldOwner');
$idUser=\filter_input(INPUT_GET, 'idUser');
$from=\filter_input(INPUT_GET, 'from');

if(isset($idBat)){
    include_once '../autoload.php';
    $owner=new Personne($pdo);
    $result=$owner->delRelationOwnerHouse($idBat,$idOldOwner,$idUser);
    echo $result;
} 