<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idStreet=\filter_input(INPUT_GET,'idStreet');
include('../autoload.php');
$sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues WHERE IdRue=:idrue';
$req=$pdo->prepare($sql);
$req->bindValue('idrue',$idStreet, PDO::PARAM_INT);
$req->execute();
foreach($req as $row){
    $html='<td><input type="text" class="form-control" name="newNom'.$idStreet.'" id="newNom'.$idStreet.'" value="'.$row['NomRue'].'" style="text-transform:uppercase;"></td>'
            . '<td><input type="text" class="form-control" name="newNaam'.$idStreet.'" id="newNaam'.$idStreet.'" value="'.$row['StraatNaam'].'"></td>'
            . '<td style="cursor:pointer;" onclick="RecEditStreet(\''.$row['IdRue'].'\');"><span class="glyphicon glyphicon-floppy-disk form-control" style="text-align:center;" aria-hidden="true" title="Enregistrer"></span></td>';
}
echo $html;