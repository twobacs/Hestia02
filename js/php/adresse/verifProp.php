<?php

include('../autoload.php');

$bat = new Batiment($pdo);

$CP=\filter_input(INPUT_GET, 'CP');
$StreetId=\filter_input(INPUT_GET, 'selectedStreetId');
$number=\filter_input(INPUT_GET, 'number');
$box=\filter_input(INPUT_GET, 'boite');
$city=\filter_input(INPUT_GET, 'city');
$idUser=\filter_input(INPUT_GET, 'idUser');

if(isset($CP)){
    //Récupérer id de la Ville
    $req=$pdo->prepare('SELECT id FROM cities WHERE zip=:zipCode');
    $req->bindValue('zipCode',$CP,  PDO::PARAM_STR);
    $req->execute();
    foreach($req as $row){
        $idCity=$row['id'];
    }
    //Récupérer id du bâtiment
    $req1=$pdo->prepare('SELECT id FROM Hestia_Batiment WHERE id_commune=:idCity AND id_rue=:street AND Numero=:number AND Boite=:box');
    $req1->bindValue('idCity',$idCity,  PDO::PARAM_STR);
    $req1->bindValue('street',$StreetId,  PDO::PARAM_INT);
    $req1->bindValue('box',$box,  PDO::PARAM_STR);
    $req1->bindValue('number',$number,  PDO::PARAM_STR);
    $req1->execute();
    foreach($req1 as $row1){
        $idBat=$row1['id'];
    }
    //Verifier en bdd si une personne est encodée comme propriétaire du bâtiment
    $idProp=$bat->getOwnerByIdBat($idBat); //retourne tableau (id_Pers + COUNT(*))
    //Si oui : afficher une alerte  avec les coordonnées du propriétaire et la possibilité de modifier cette donnée
    $html='<p class="boutonC85">Identit&eacute; du propri&eacute;taire</p>';
    $i=0;
    foreach($idProp as $rowa){
        $owner=new Personne($pdoU, $pdoH);
        $idOwner=$rowa['id_Pers'];
        $ownerData=$owner->getInfosByIdPers($idOwner);
        foreach($ownerData as $row){
            $html.='<div class="form-horizontal" name="infosOwner_'.$idOwner.'">'
                    . '<div class="form-group">'
                    . '     <div class="col-sm-1">'
                    . '         <input type="text" class="form-control" value="'.($i+1).'" disabled>'
                    . '     </div>'
                    . '     <div class="col-sm-5">'
                    . '         <input type="text" class="form-control" name="Nom_'.$idOwner.'" id="Nom_'.$idOwner.'" placeHolder="Nom" value="'.strtoupper($row['Nom']).'">'
                    . '     </div>'
                    . '     <div class="col-sm-5">'
                    . '         <input type="text" class="form-control"  name="Prenom_'.$idOwner.'" id="Prenom_'.$idOwner.'" placeHolder="Prenom" value="'.$row['Prenom'].'">'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . '     <label for="GSM_'.$idOwner.'" class="col-sm-2 control-label">GSM :</label>'
                    . '     <div class="col-sm-3">'
                    . '         <input type="tel" class="form-control" name="GSM_'.$idOwner.'" id="GSM_'.$idOwner.'" placeHolder="GSM" value="'.$row['GSM'].'">'
                    . '     </div>'
                    . '     <label for="Pays_'.$idOwner.'" class="col-sm-2 control-label">Pays :</label>'
                    . '     <div class="col-sm-3">'
                    . '         <input type="tel" class="form-control" name="Pays_'.$idOwner.'" id="Pays_'.$idOwner.'" placeHolder="Pays" value="'.$row['Pays'].'">'
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
                    . '<input class="bMenu2" src="./media/icons/bSave.jpg" type="image" align="center" onclick="saveModifOwner(\''.$idOwner.'\');">'
                    . '<input class="bMenu2" src="./media/icons/bTrash.jpg" type="image" align="center" onclick="delRelationOwnerHouse(\''.$idBat.'\',\''.$idOwner.'\',\''.$idUser.'\',\'1\');">'
                    . '</center>'
                    . '</div>'
                    . '<hr>';
            }
    $i++;
    }
        
    if($i===0){
        $html.='no owner';
    }
    $html.='<center>'
            . '<div id="formAddOwner"></div>'
                    . '<input class="bMenu2" src="./media/icons/bNouveau.png" type="image" onclick="formAddOwner(\''.$idBat.'\',\''.$idUser.'\');"><br /><br />'
                    . '<input class="bMenu2" src="./media/icons/bSortir.jpg" type="image" align="center" onclick="hideResult();">'
                    . '</center>';
    
    echo $html;
    
}