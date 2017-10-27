<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');
$search=\filter_input(INPUT_GET,'IdRue');

$sql='SELECT IdRue, NomRue, StraatNaam FROM z_rues WHERE IdRue=:search';
$req=$pdo->prepare($sql);
$req->bindValue('search',$search, PDO::PARAM_INT);
$req->execute();

$html='<p class="boutonC45" style="cursor:default;margin-top:15px;">Sections actuelles</p>';
$html.='<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
            . '<tr><th>Nom</th><th>C&ocirc;t&eacute;</th><th>Limite basse</th><th>Limite haute</th><th coslpan="2">Quartier</th></tr>';
foreach($req as $row){
        $sqla='SELECT a.id, a.cote, a.limiteBas, a.limiteHaut, a.cote, a.limiteBas, a.limiteHaut, b.denomination AS denomQ, a.id_quartier, c.denomination AS denomA '
                . 'FROM z_quartier_rue a '
                . 'LEFT JOIN z_quartier b ON b.id_quartier = a.id_quartier '
                . 'LEFT JOIN z_antenne_quartier c ON c.id_antenne = b.id_antenne '
                . 'WHERE a.IdRue=:idRue '
                . 'ORDER BY a.cote, a.limiteBas';
        $reqa=$pdo->prepare($sqla);
        $reqa->bindValue('idRue',$row['IdRue'], PDO::PARAM_INT);
        $reqa->execute();
        $i=0;
        foreach ($reqa as $rowa){
            $html.='<tr><td title="'.$row['StraatNaam'].'"><input type="text" class="form-control" disabled value="'.$row['NomRue'].'"></td><td><input type="text" class="form-control" style="max-width:75px;" disabled value="';
            $html.=($rowa['cote']=='I')?'Impair':'Pair';
            $html.='"></td>'
                    . '<td style="text-align:center;"><input type="text" class="form-control" id="row'.$i.$rowa['cote'].'bas" style="max-width:75px;" value="'.$rowa['limiteBas'].'" onfocusout="modifLimite(\'bas\',\''.$search.'\',\''.$rowa['cote'].'\',\''.$i.'\',\''.$rowa['id'].'\');"></td>'
                    . '<td style="text-align:center;"><input type="text" class="form-control" id="row'.$i.$rowa['cote'].'haut" style="max-width:75px;" value="'.$rowa['limiteHaut'].'" onfocusout="modifLimite(\'haut\',\''.$search.'\',\''.$rowa['cote'].'\',\''.$i.'\',\''.$rowa['id'].'\');"></td>';
        
        $sqlb='SELECT id_quartier, denomination, id_antenne FROM z_quartier ORDER BY denomination';
        $reqb=$pdo->prepare($sqlb);
        $reqb->execute();
        $html.='<td><select class="form-control" style="max-width:250px;" id="selectQuartier'.$i.'" onchange="modifQuartierForSection(\''.$rowa['id'].'\',\''.$i.'\');">';
        foreach($reqb as $rowb){       
            $html.='<option value="'.$rowb['id_quartier'].'"';
            $html.=($rowb['id_quartier']==$rowa['id_quartier'])?' selected': '';
            $html.='>'.$rowb['denomination'].'</option>';
        }
        $html.='</select></td><td><img style="cursor:pointer;"src="./media/icons/delete.gif" title="Supprimer d&eacute;coupe" onclick="delRowLinkStreetQuartier(\''.$rowa['id'].'\',\''.$search.'\');"></td></tr>';
        $i++;
        }
   }
   $html.='<tr><td colspan="6" align="center"><input type="button" class="form-control" value="Ajouter une section" onclick="addPortion(\''.$row['IdRue'].'\');"></td></table></div>';
   $html.='<div id="zoneAddPortion"></div>';

echo $html;