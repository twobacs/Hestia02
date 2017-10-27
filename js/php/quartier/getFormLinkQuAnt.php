<?php

include ('../autoload.php');
$idAntenne=\filter_input(INPUT_GET,'idAntenne');
$acces=  \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');

$sql='SELECT id_quartier, denomination, gsm FROM z_quartier WHERE id_antenne=:idAntenne ORDER BY denomination';
$req=$pdo->prepare($sql);
$req->bindValue('idAntenne',$idAntenne,PDO::PARAM_INT);
$req->execute();
$html='<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;">';
foreach($req as $row){
  $html.='<tr><th style="width:75px;cursor:default;">D&eacute;nomination</th>'
          . '<td style="width:440px;cursor:pointer;" title="&Eacute;diter" onclick="getFormEditQuartierById(\''.$row['id_quartier'].'\',\''.$acces.'\',\''.$user.'\');">'.$row['denomination'].'</td>'
          . '<td><span class="glyphicon glyphicon-phone" aria-hidden="true"></span></td>'
          . '<td style="cursor:default;">'.$row['gsm'].'</td>'
          . '<td style="cursor:pointer;" title="Supprimer liaison" onclick="delLinkQuAnt(\''.$idAntenne.'\',\''.$row['id_quartier'].'\',\''.$acces.'\',\''.$user.'\');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>'
          . '</tr>';
}
$html.='<tr><td class="info" colspan="5" style="text-align:center;cursor:pointer;" onclick="getFormAddAntToQuart(\''.$idAntenne.'\',\''.$acces.'\',\''.$user.'\');">Ajouter un quartier</td></tr>';
$html.='<tr><td class="danger" colspan="5" style="text-align:center;cursor:pointer;" onclick="getFormAddAntToQuart(\''.$idAntenne.'\',\''.$acces.'\',\''.$user.'\');">Retour</td></tr>';
$html.='</table></div>';
$html.='<div id="placeToAddAntToQuart_'.$idAntenne.'"></div>';
echo $html;