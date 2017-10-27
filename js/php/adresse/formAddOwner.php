<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idUser=\filter_input(INPUT_GET, 'user');
$idBat=\filter_input(INPUT_GET, 'idBat');

if(isset($idUser)){
    include ('../autoload.php');
    $html='<p class="boutonC85">Ajout d\'un propri&eacute;taire';
    $html.='<div class="form-horizontal" name="infosOwner_'.$idOwner.'">'
                    . '<div class="form-group">'
                    . '<label for="GSM_-1" class="col-sm-2 control-label">Identit&eacute; :</label>'
                    . '     <div class="col-sm-4">'
                    . '         <input type="text" class="form-control" name="Nom_'.$idOwner.'" id="Nom_'.$idOwner.'" placeHolder="Nom" value="'.strtoupper($row['Nom']).'">'
                    . '     </div>'
                    . '     <div class="col-sm-5">'
                    . '         <input type="text" class="form-control"  name="Prenom_'.$idOwner.'" id="Prenom_'.$idOwner.'" placeHolder="Prenom" value="'.$row['Prenom'].'" onkeyup="verifPersExistsAddPersToBat(\''.$idBat.'\',\''.$idUser.'\');">'
                    . '     </div>'
                    . '</div>'
                    . '<div id="PersExists"></div>'
                    . '<div class="form-group">'
                    . '     <label for="GSM_'.$idOwner.'" class="col-sm-2 control-label">GSM :</label>'
                    . '     <div class="col-sm-3">'
                    . '         <input type="tel" class="form-control" name="GSM_'.$idOwner.'" id="GSM_'.$idOwner.'" placeHolder="GSM" value="'.$row['GSM'].'">'
                    . '     </div>'
                    . '     <label for="Pays_'.$idOwner.'" class="col-sm-2 control-label">Pays :</label>'
                    . '     <div class="col-sm-3">'
                    . '         <input type="tel" class="form-control" name="Pays_'.$idOwner.'" id="Pays_'.$idOwner.'" placeHolder="Pays" value="Belgique">'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . '     <label class="col-sm-2 control-label">Adresse :</label>'
                    . '     <div class="col-sm-2">'
                    . '         <input type="text" class="form-control" name="CP_'.$idOwner.'" id="CP_'.$idOwner.'" placeHolder="CP" value="'.$row['CP'].'" onkeyup="getVilleByCP(\''.$idOwner.'\');">'
                    . '     </div>'
                    . '     <div class="col-sm-2">'
                    . '         <div id="NCity_'.$idOwner.'"><input type="text" class="form-control" disabled name="City_'.$idOwner.'" id="City_'.$idOwner.'" placeHolder="Ville" value="'.strtoupper($row['Ville']).'"></div>'
                    . '     </div>'
                    . '     <div class="col-sm-3">'
                    . '         <div id="NStreet_'.$idOwner.'"><input type="text" class="form-control" name="Street_'.$idOwner.'" id="Street_'.$idOwner.'" placeHolder="Rue" value="'.$row['Rue'].'" disabled></div>'
                    . '     </div>'
                    . '     <div class="col-sm-1">'
                    . '         <input type="text" class="form-control" name="Number_'.$idOwner.'" id="Number_'.$idOwner.'" placeHolder="N°" value="'.$row['Num'].'" disabled>'
                    . '     </div>'
                    . '     <div class="col-sm-1">'
                    . '         <input type="text" class="form-control" name="Box_'.$idOwner.'" id="Box_'.$idOwner.'" placeHolder="Bte" value="'.$row['Bte'].'" disabled>'
                    . '     </div>'
                    . '</div>'
                    . '<center>'
                    . '<input class="bMenu2" src="./media/icons/bSave.jpg" type="image" align="center" onclick="addOwnerToBat(\''.$idBat.'\',\''.$idUser.'\');">';
    $html.='</div><hr>';
    echo $html;
}