<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idOwner=\filter_input(INPUT_GET, 'idOwner');
include('../autoload.php');
if($idOwner){
    $idStreet='Street_'.$idOwner;
}
else $idStreet="Street";
$req=$pdo->prepare('SELECT IdRue, NomRue, StraatNaam FROM z_rues ORDER BY NomRue');
$req->execute();
$html='<select class="form-control" name="'.$idStreet.'" id="'.$idStreet.'"><option disabled selected value="-1">Veuillez s&eacute;lectionner</option>';
        foreach($req as $row){
            $html.='<option value="'.$row['IdRue'].'">'.$row['NomRue'].'</option>';
        }
$html.='</select>';
echo $html;
?>