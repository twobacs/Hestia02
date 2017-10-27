<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idOwner=\filter_input(INPUT_GET, 'idOwner');
$idUser=\filter_input(INPUT_GET, 'idUser');
if(isset($idOwner)){
    include ('../autoload.php');
    $object=new Personne($pdo);
    $data=$object->getInfosByIdPers($idOwner);
    $html='<h4>Modifier les donn&eacute;es  de contact d\'un propri&eacute;taire</h4>';
    foreach($data as $row){
        $html.='<table class="tableResult">'
                . '<tr><th>Nom</th><td>'.$row['Nom'].'</td></tr>'
                . '<tr><th>Pr&eacute;nom</th><td>'.$row['Prenom'].'</td></tr>'
                . '<tr><th>T&eacute;l&eacute;phone</th><td><input autofocus type="text" name="newPhone" id="newPhone" value="'.$row['TelFixe'].'" autofocus></td></tr>'
                . '<tr><th>GSM</th><td><input type="text" name="newMobile" id="newMobile" value="'.$row['GSM'].'"></td></tr>'
                . '<tr style="cursor:pointer;" onclick="recordModifOwner(\''.$idOwner.'\');"><td colspan="2"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true" alt="Enregistrer"></span> Enregistrer les modifications</td></tr>'
                . '<tr style="cursor:pointer;" onclick="verifProp(\''.$idOwner.'\');"><td colspan="2"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true" alt="Retour"></span> Revenir &agrave; l\' &eacute;cran pr&eacute;c&eacute;dent</td></tr>';
    }
    echo $html;
}