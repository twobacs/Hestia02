<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$nom=\filter_input(INPUT_GET, 'Nom');
$prenom= \filter_input(INPUT_GET, 'Prenom');
$idBat= \filter_input(INPUT_GET, 'idBat');
$idUser= \filter_input(INPUT_GET, 'idUser');

$sql='SELECT id, DateNaissance, Nom, Prenom, GSM FROM Hestia_Personne WHERE Nom=:nom AND Prenom LIKE :prenom';
$req=$pdo->prepare($sql);
$req->bindValue('nom',$nom,  PDO::PARAM_STR);
$req->bindValue('prenom',$prenom.'%', PDO::PARAM_STR);
$req->execute();
if($req->rowCount()>0){
    $html='';
    foreach ($req as $row) {
        $html.='<span id="HelpBlock" class="help-block"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> '.strtoupper($row['Nom']).' '.ucfirst($row['Prenom']).''
                . ', n&eacute; le '.dateFr($row['DateNaissance']).', existe d&eacute;j&agrave; dans le syst&egrave;me.'
                . '  <a href="#" onclick="addExistsOwnerToBat(\''.$idBat.'\',\''.$idUser.'\',\''.$row['id'].'\');">Reprendre cette personne.</a><br />'
                . '</span>';
    }
}
echo $html;