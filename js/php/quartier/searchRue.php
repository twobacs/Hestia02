<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$search=\filter_input(INPUT_GET,'search');
include ('../autoload.php');
$sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues WHERE NomRue LIKE "%'.$search.'%" OR StraatNaam LIKE "%'.$search.'%"';
$req=$pdo->query($sql);
$html='<div class="table-reponsive">'
        . '<table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;"><tr><th colspan="3" style="text-align:center;">R&eacute;sultat(s)</th></tr>';
foreach($req as $row){
    $html.='<tr id="IdStreetN'.$row['IdRue'].'"><td>'.$row['NomRue'].'</td><td>'.$row['StraatNaam'].'</td><td style="cursor:pointer;" onclick="editStreet(\''.$row['IdRue'].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true" title="&Eacute;diter"></span></td></tr>';
}
$html.='</table>';
echo $html;