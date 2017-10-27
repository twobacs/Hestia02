<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$side=\filter_input(INPUT_GET,'side');
$idStreet=\filter_input(INPUT_GET,'idStreet');
$LB=\filter_input(INPUT_GET,'limiteBasse');
$LH=\filter_input(INPUT_GET,'limiteHaute');

//Sélectionner en bdd les sections correspondantes au côté "p" ou "i" sur base de l'id de la rue
$sql='SELECT limiteBas, limiteHaut FROM z_quartier_rue WHERE idRue=:idRue AND cote=:cote';
$req=$pdo->prepare($sql);
$req->bindValue('idRue',$idStreet, PDO::PARAM_INT);
$req->bindValue('cote',$side, PDO::PARAM_STR);
$req->execute();

$okB=true;
$okH=true;
//Pour chacune des section, vérifier pour chacun des nombres introduits qu'il n'est pas déjà inclus dans un intervalle existant
foreach($req as $row){
    if(($LB>=$row['limiteBas'])&&($LB<=$row['limiteHaut'])){$okB=false;}
    if(($LH>=$row['limiteBas'])&&($LH<=$row['limiteHaut'])){$okH=false;}
}
//Si tout est ok, renvoyer valeur 1
if($okB && $okH){
    echo '1';
}

//Si erreur, renvoyer valeur B(asse) ou H(aute), correspondant à la où se trouve le problème (D si les deux)
else{
    if (!$okB && !$okH){echo 'D';}
    else if(!$okB && $okH){echo 'B';}
    else if($okB && !$okH){echo 'H';}
}