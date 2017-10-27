<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$id=\filter_input(INPUT_GET, 'id');
$data['TelFixe']=\filter_input(INPUT_GET, 'newPhone');
$data['GSM']=\filter_input(INPUT_GET, 'newMobile');

if(isset($id)){
    include('../autoload.php');
    $personne=new Personne($pdo);
    echo $personne->updateById($id,$data);
    
}