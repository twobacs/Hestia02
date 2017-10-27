<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */
include ('../autoload.php');
$idRue=\filter_input(INPUT_GET,'IdRue');
$sql='SELECT NomRue FROM z_rues WHERE IdRue=:search';
$req=$pdo->prepare($sql);
$req->bindValue('search',$idRue, PDO::PARAM_INT);
$req->execute();
foreach($req as $row){
    $nomRue=$row['NomRue'];
}

$sqla='SELECT id_quartier, denomination FROM z_quartier ORDER BY denomination';
$reqa=$pdo->query($sqla);
$html=''
        . '<p class="boutonC45" style="cursor:default;">Ajout d\'une section</p>'
        . '<div class="table-responsive"><table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
        . '<tr><td><input type="text" class="form-control" value="'.$nomRue.'" disabled></td>'
        . '<td><select class="form-control" name="sideNewPortion" id="sideNewPortion" style="max-width:100px" title="C&ocirc;t&eacute;"><option value="P">Pair</option><option value="I">Impair</option></select></td>'
        . '<td><input type="text" class="form-control" id="newDownLimit" name="newDownLimit" style="max-width:75px;" title="Limite basse"></td>'
        . '<td><input type="text" class="form-control" id="newHighLimit" name="newHighLimit" style="max-width:75px;" title="Limite haute"></td></tr>'
        . '<tr><td>Quartier</td><td colspan="2">'
        . '<select class="form-control" id="NewQ"><option value="-1">Veuillez choisir</option>';
foreach($reqa as $rowa){
    $html.='<option value="'.$rowa['id_quartier'].'">'.$rowa['denomination'].'</option>';
}
$html.='</select>'
        . '</td><td><img id="bRecNewSection" src="./media/icons/bSave.jpg" style="max-height:30px;" title="Enregistrer" onclick="addNewPortion(\''.$idRue.'\');"></td>'
        . '</tr>'
        . '</table></div>';


echo $html;