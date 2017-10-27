<?php
include('../autoload.php');

$idStreet= \filter_input(INPUT_GET, 'idStreet');
$zip= \filter_input(INPUT_GET, 'zipCode');
$number= \filter_input(INPUT_GET, 'number');
$city= \filter_input(INPUT_GET, 'city');
$box= \filter_input(INPUT_GET, 'box');
$user= \filter_input(INPUT_GET, 'user');

if(isset($idStreet)){
    $req=$pdo->prepare('SELECT id FROM cities WHERE zip=:zip AND name=:city');
    $req->bindValue('zip',$zip,  PDO::PARAM_INT);
    $req->bindValue('city',$city,  PDO::PARAM_STR);
    $req->execute();
    foreach($req as $row){
        $idCity=$row['id'];        
    }
    $query='SELECT id, COUNT(*) as count FROM Hestia_Batiment WHERE id_commune="'.$idCity.'" AND id_rue="'.$idStreet.'" AND Numero="'.$number.'"';
    $query.=($box==='') ? '' : ' AND Boite="'.$box.'"';
    $rep=$pdo->query($query);
    while($row=$rep->fetch()){
        $count=$row['count'];
        $idHouse=$row['id'];
    }
    if($count=='0'){ //Habitation non existante en base de données.
        noExist($idCity,$idStreet,$number,$box,$pdoU);
    }
    
    else{
        //Vérifier les habitant existants, les présenter sous forme de liste le cas échéant
        $rep=$pdo->query('SELECT COUNT(*) as count FROM Hestia_Pers_Bat WHERE id_Bat="'.$idHouse.'" AND Actif="O" AND id_Rel>"1"');
        while($row=$rep->fetch()){
            $count=$row['count'];
        }
        if($count==='0'){
            //Aucun habitant
            echo 'nobody';  //Afin de ne pas afficher la fenêtre d'informations
        }
        else{
            //Des habitant sont répertoriés et "actifs" à cette adresse
            showCitizenByIdHouse($idHouse,$user,$pdo);
        }
        
    }
}

function noExist($nIdCity,$nIdStreet,$nNumber,$nBox,$pdoU){
    $req=$pdo->prepare('SELECT NomRue FROM z_rues WHERE IdRue=:id');
    $req->bindValue('id',$nIdStreet,  PDO::PARAM_INT);
    $req->execute();
    foreach ($req as $row) {
        $nomRue=$row['NomRue'];
    }
    echo 'Cette habitation n\'existe pas, d&eacute;sirez-vous la cr&eacute;er ? <br />('.$nomRue.' '.$nNumber.' '.$nBox.')<br />'
    . '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="cursor:pointer;" alt="Oui" onclick="CreateNewHouse(\''.$nIdCity.'\',\''.$nIdStreet.'\',\''.$nNumber.'\',\''.$nBox.'\');"></span>    '
    . '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="cursor:pointer;" alt="Non" onclick="hideResult();"></span>';
}

function showCitizenByIdHouse($idHouse,$user,$pdo){
    $html='<h3>Des personnes sont d&eacute;j&agrave; inscrites &agrave; cette adresse</h3>';
    $req=$pdo->prepare('SELECT a.id, a.Nom, a.Prenom, a.DateNaissance, b.DateIn, b.id AS idPB FROM Hestia_Personne a LEFT JOIN Hestia_Pers_Bat b ON a.id=b.id_Pers WHERE b.id_Bat=:idHouse AND b.Actif="O" AND NOT b.id_Rel="1"');
    $req->bindValue('idHouse',$idHouse,  PDO::PARAM_INT);
    $req->execute();
    foreach ($req as $row){
        $html.=$row['Nom'].' '.$row['Prenom'].' ('.dateFr($row['DateNaissance']).'), depuis le : '.dateFr($row['DateIn']).' <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style="cursor:pointer;" alt="Supprimer" onclick="delRelationCitizenHouse(\''.$row['idPB'].'\',\''.$user.'\');"></span><br />';
    }
    $html.='<span onclick="hideResult();" class="glyphicon glyphicon-ok" aria-hidden="true" style="cursor:pointer;" alt="Ok"> Conserver enregistrement(s)</span>';
    echo $html;
}
?>