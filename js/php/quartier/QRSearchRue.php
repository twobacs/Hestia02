<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$search=\filter_input(INPUT_GET,'rue');

if(is_numeric($search)){
    $sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues WHERE IdRue=:search';
    $req=$pdo->prepare($sql);
    $req->bindValue('search',$search, PDO::PARAM_INT);
    $req->execute();
}

else{
    $sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues WHERE NomRue LIKE :search';
    $req=$pdo->prepare($sql);
    $req->bindValue('search','%'.$search.'%', PDO::PARAM_STR);
    $req->execute();
}

$nbStreet=array();
$i=0;
$html='<p class="boutonC45" style="cursor:default;margin-top:15px;">R&eacute;sultat de votre recherche</p>';
if($req->rowCount()>4){
    $html.='<p style="margin-left:75px;max-width:755px;text-align:center;">La requête a retourn&eacute; un trop grand nombre de r&eacute;ponses, veuillez affiner votre recherche.</p>';
}

else{
    $html.='<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
            . '<tr><th>Nom</th><th>C&ocirc;t&eacute;</th><th>Limite basse</th><th>Limite haute</th><th>Quartier</th></tr>';
    foreach ($req as $row){
        if(!in_array($row['IdRue'],$nbStreet)){array_push($nbStreet, $row['IdRue']);}
        $sqla='SELECT a.cote, a.limiteBas, a.limiteHaut, a.cote, a.limiteBas, a.limiteHaut, b.denomination AS denomQ, c.denomination AS denomA '
                . 'FROM z_quartier_rue a '
                . 'LEFT JOIN z_quartier b ON b.id_quartier = a.id_quartier '
                . 'LEFT JOIN z_antenne_quartier c ON c.id_antenne = b.id_antenne '
                . 'WHERE a.IdRue=:idRue '
                . 'ORDER BY a.cote, a.limiteBas';
        $reqa=$pdo->prepare($sqla);
        $reqa->bindValue('idRue',$row['IdRue'], PDO::PARAM_INT);
        $reqa->execute();
        //echo $req['NomRue'];
        if($reqa->rowCount()!='0'){
            foreach ($reqa as $rowa){
                $html.='<tr><td title="'.$row['StraatNaam'].'">'.$row['NomRue'].'</td><td>';
                $html.=($rowa['cote']=='I')?'Impair':'Pair';
                $html.='</td><td style="text-align:center;">'.$rowa['limiteBas'].'</td><td style="text-align:center;">'.$rowa['limiteHaut'].'</td><td title="'.$rowa['denomA'].'">'.$rowa['denomQ'].'</td></tr>';
            }
        }
        else{
            $html.='<tr><td colspan="5">Aucune information n\'est disponible pour cette rue</td></tr>';
        }
    }
    if(sizeof($nbStreet)==1){
    $html.='</table></div><p class="boutonC45" style="cursor:pointer;" onclick="modifDecoupe(\''.$row['IdRue'].'\');">Ajouter - modifier - supprimer une d&eacute;coupe</p><div id="editStreetPlace"></div>';
    }
}
echo $html;