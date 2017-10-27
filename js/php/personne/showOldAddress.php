<?php

include('../autoload.php');

$oldZip=\filter_input(INPUT_GET, 'oldZip');
$oldCity=\filter_input(INPUT_GET, 'oldCity');
$oldNumber=\filter_input(INPUT_GET, 'oldNumber');
$oldStreet=\filter_input(INPUT_GET, 'oldStreet');
$dateIn=\filter_input(INPUT_GET, 'dateIn');
$idPersBat=\filter_input(INPUT_GET, 'idPersBat');
$idUser=\filter_input(INPUT_GET, 'idUser');

if(isset($idPersBat)){
    $html='<h4>Cette personne est d&eacute;j&agrave; enregistr&eacute;e &agrave; une autre adresse</h4>';
    $html.='Adresse enregistr&eacute;e : '.$oldZip.' '.$oldCity.', '.$oldStreet.', '.$oldNumber.'. (Depuis le : '.dateFr($dateIn).')<br />';    
    $html.='<span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style="cursor:pointer;" alt="Supprimer" onclick="delRelationCitizenHouse(\''.$idPersBat.'\',\''.$idUser.'\',\'1\');"></span> Supprimer cette relation<br />'
            . '<span style="cursor:pointer;" class="glyphicon glyphicon-ok" aria-hidden="true" alt="Ok" onclick="hideResult();">Conserver cet enregistrement</span>';
    echo $html;
}