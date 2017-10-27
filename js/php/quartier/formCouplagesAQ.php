<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');
$user=\filter_input(INPUT_GET,'user');
$acces=\filter_input(INPUT_GET,'acces');

$sqlQ='SELECT id_quartier, denomination FROM z_quartier ORDER BY denomination';
$reqQ=$pdo->query($sqlQ);

$sqlU='SELECT id_user, nom, prenom FROM users ORDER BY nom';
$reqU=$pdo->query($sqlU);
        

$html='<p class="boutonC85" style="cursor:pointer;" onclick="slide(\'addQuartier\');">Ajout d\'une liaison</p>';
$html.='<div id="addQuartier" style="display:none;">'
        . '<table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
        . '<tr><td>'
        . '<SELECT class="form-control" name="selectedQuartier" id="selectedQuartier">';
        foreach($reqQ as $rowQ){
            $html.='<option value="'.$rowQ['id_quartier'].'">'.$rowQ['denomination'].'</option>';
        }
        $html.= '</SELECT>'
        . '</td></tr>'
        . '<tr><td>'
        . '<SELECT class="form-control" name="selectedUser" id="selectedUser">';
        foreach($reqU as $rowU){
            $html.='<option value="'.$rowU['id_user'].'">'.$rowU['nom'].' '.$rowU['prenom'].'</option>';
        }
        $html.= '</SELECT>'
        . '</td></tr>'
        . '<td><p class="boutonC45" style="cursor:pointer;" onclick="addNewLinQAQ(\''.$acces.'\',\''.$user.'\');">Enregistrer</p></td>'
        . '</table>'
        . '</div>';

//Récupérer les infos de la table z_agent_quartier (alias a) sur BDD Polimo
//Récupérer les dénomination depuis la table z_quartier (alias b)
//Récupérer les noms des AQ depuis la table users (alias c)
$sql='SELECT a.id AS idLinkQA, b.denomination, c.nom, c.prenom '
        . 'FROM z_agent_quartier a '
        . 'LEFT JOIN z_quartier b ON b.id_quartier = a.id_quartier '
        . 'LEFT JOIN users c ON c.id_user = a.id_user '
        . 'ORDER BY b.denomination';

$req=$pdo->query($sql);

$html.='<p class="boutonC85" style="cursor:default;" onclick="slide(\'tabLink\');">Liaisons actuelles</p>'
        . '<div id="tabLink"><table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'; 
foreach($req as $row){
    $html.='<tr id="linkQA_'.$row['idLinkQA'].'">'
            . '<th>'.$row['denomination'].'</th>'
            . '<td>'.$row['nom'].' '.$row['prenom'].'</td>'
            . '<td>'
            . '<img src="./media/icons/bModif.png" style="max-height:19px;cursor:pointer;" title="Modifier"'
            . ' onclick="editLinkQAQ(\''.$row['idLinkQA'].'\',\''.$acces.'\',\''.$user.'\');">  '
            . '<img src="./media/icons/bTrash.jpg" style="max-height:19px;cursor:pointer;" title="Supprimer"'
            . ' onclick="deleteLinkQAQ(\''.$row['idLinkQA'].'\',\''.$acces.'\',\''.$user.'\');">'
            . '</td>'
            . '</tr>';
}
$html.='</table></div>';

echo $html;