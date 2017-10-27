<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');
$html='';
$idQ=\filter_input(INPUT_GET,'Quart');
$sql='SELECT b.IdRue, b.NomRue, a.cote, a.limiteBas, a.limiteHaut FROM '
        . 'z_quartier_rue a '
        . 'LEFT JOIN z_rues b ON b.IdRue = a.IdRue '
        . 'WHERE a.id_quartier=:idQuartier '
        . 'ORDER BY b.NomRue';
$req=$pdo->prepare($sql);
$req->bindValue('idQuartier',$idQ, PDO::PARAM_INT);
$req->execute();
$html='<SELECT class="form-control" name="idRue" id="idRue">';
foreach ($req as $row){
    $html.='<option value="'.$row['IdRue'].'">'.$row['NomRue'].' - C&ocirc;t&eacute; ';
    $html.=($row['cote']=='P')?'pair':'impair';
    $html.=', de '.$row['limiteBas'].' &agrave; '.$row['limiteHaut'].'</option>';
}
$html.='</select>';
echo $html;