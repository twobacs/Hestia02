<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');

include ('../autoload.php');

$sql="SELECT IdRue, NomRue FROM z_rues ORDER BY NomRue";
$req=$pdo->query($sql);
//$req->execute();

$selectRues='<SELECT class="form-control" name="selectStreet" id="selectStreet" style="margin-left:75px;max-width:755px;" onchange="searchRueQRSelect();"><option value="-1"></option>';
foreach ($req as $value) {
    $selectRues.='<option value="'.$value['IdRue'].'">'.$value['NomRue'].'</option>';
}
$selectRues.='</SELECT>';


$searchStreetZone='<INPUT TYPE=text" class="form-control" id="searchRue" name="searchRue" style="margin-left:75px;max-width:755px;" placeholder="Tapez ici votre recherche" onkeyup="searchRueQRText();">';



$html='<p class="boutonC85" style="cursor:default;">Couplage rues - quartier</p>'
        . '<p class="boutonC85 style="cursor:default;">Par s&eacute;lection de rue</p>';
$html.=$selectRues.'<hr style="margin-left:75px;max-width:755px;">';

$html.='<p class="boutonC85 style="cursor:default;">Par nom de rue</p>';
$html.=$searchStreetZone;

$html.='<div id="resultSearch"></div>';
echo $html;