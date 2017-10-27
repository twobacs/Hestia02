<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

//$idBat=\filter_input(INPUT_GET, 'idBat');
//\print_r(\array_keys($_GET));
include ('../autoload.php');
$owner = new Personne($pdo);
//echo 'ok';
echo $owner->addOwnerToBat($_GET);