<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idAntenne=\filter_input(INPUT_GET,'idAntenne');
$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');

include ('../autoload.php');
$sql='SELECT denomination, id_quartier FROM z_quartier WHERE id_antenne=:idAntenne';
$req=$pdo->prepare($sql);
$req->bindValue(idAntenne,"0",  PDO::PARAM_INT);
$req->execute();
if($req->rowCount()>0){
    $html='<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;text-align:center;">';
    foreach($req as $row){
        $html.='<tr><th style="cursor:default;">D&eacute;nomination</th><td style="cursor:default;">'.$row['denomination'].'</td><td onclick="addLinkAntQuart(\''.$idAntenne.'\',\''.$row['id_quartier'].'\',\''.$acces.'\',\''.$user.'\');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="cursor:pointer;" title="Lier &agrave; cette antenne"></span></td></tr>';
    }
    $html.='</table></div>';
}
else $html='<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;text-align:center;">'
        . '<tr><td style="cursor:default;"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Tous les quartiers sont d&eacute;j&agrave; li&eacute;s &agrave; une antenne.</td></tr>'
        . '</table></div>';
echo $html;