<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$acces= \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');

$html='<p class="boutonC85" style="cursor:default;">Gestion des rues</p>';
$html.='<p class="boutonC85" style="cursor:default;">Rues existantes</p>';

$sql='SELECT NomRue, StraatNaam, idRue FROM z_rues ORDER BY NomRue';
$req=$pdo->query($sql);

$selectRues='<select class="form-control" name="ExistStreets" id="ExistStreets" onchange="editStreetFromSelectedStreet();"><option></option>';
foreach ($req as $row){
    $selectRues.='<option value="'.$row['idRue'].'">'.$row['NomRue'].' ('.$row['StraatNaam'].')</option>';
}
$selectRues.='</select>';

$html.='<div class="table-responsive">'
        . '<table class=" table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
        . '<tr><th style="width:75px;">Liste</th><td>'.$selectRues.'</td></tr>'
        . '<tr><th style="width:75px;">Recherche</th><td><input type="text" class="form-control" name="searchRue" id="searchRue" onkeyup="searchRue();" placeholder="Tapez votre recherche..."></td></tr>'
        . '</table>'
        . '</div>'
        . '<div id="resultSearch"></div>'
        . '<p class="boutonC85" style="cursor:default;">Ajouter une rue</p>'
        . '<div class="table-responsive">'
        . '<table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
        . '<tr><th style="width:75px;">Nom FR</th><td><input class="form-control" name="nouvelleRue" id="nouvelleRue" style="text-transform:uppercase;" type="text" required></td></tr>'
        . '<tr><th style="width:75px;">Nom NL</th><td><input class="form-control" name="nieuweStraat" id="nieuweStraat" style="text-transform:uppercase;" type="text"></td></tr>'
        . '<tr><td></td><td><input type="button" class="form-control" value="Enregistrer" onclick="AddNewStreet(\''.$acces.'\',\''.$user.'\')";></td></tr>'
        . '</div>';

echo $html;