<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include('../autoload.php');
$html='';
$idLinkQA=\filter_input(INPUT_GET,'idLinkQA');
$acces=\filter_input(INPUT_GET,'acces');
$user=\filter_input(INPUT_GET,'user');

$sql='SELECT a.id AS idLinkQA, a.id_user, b.denomination, c.nom, c.prenom '
        . 'FROM z_agent_quartier a '
        . 'LEFT JOIN z_quartier b ON b.id_quartier = a.id_quartier '
        . 'LEFT JOIN users c ON c.id_user = a.id_user '
        . 'WHERE a.id =:idLink '
        . 'ORDER BY b.denomination';
$req=$pdo->prepare($sql);
$req->bindValue('idLink',$idLinkQA, PDO::PARAM_INT);
$req->execute();

$sqlUsers='SELECT id_user, nom, prenom, matricule FROM users WHERE actif="O" ORDER BY nom';
$reqU=$pdo->query($sqlUsers);

foreach($req as $row){
    $html.='<th>'.$row['denomination'].'</th>'
            . '<td>';
            $html.='<SELECT class="form-control" name="selectAQ" id="selectAQ" onchange="modifLinkQAQ(\''.$idLinkQA.'\',\''.$acces.'\',\''.$user.'\');">';
            foreach($reqU as $rowU){
                $html.='<option value="'.$rowU['id_user'].'"';
                $html.=($row['id_user']==$rowU['id_user'])?' selected' : '';
                $html.='>'.$rowU['nom'].' '.$rowU['prenom'].'</option>';
            }
            $html.='</select>';
            $html.='</td>';
}
echo $html;