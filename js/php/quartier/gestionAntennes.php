<?php

/*
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

include ('../autoload.php');

$acces= \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');

$html='<p class="boutonC85" style="cursor:default;">Gestion des antennes</p>';
$sql='SELECT a.id_antenne, a.denomination, a.numero, a.telephone, a.fax, '
        . 'b.nom, b.prenom, '
        . 'c.NomRue '
        . 'FROM z_antenne_quartier a '
        . 'LEFT JOIN users b ON b.id_user = a.id_resp '
        . 'LEFT JOIN z_rues c ON c.idRue = a.idRue '
        . 'ORDER BY a.denomination';
$req=$pdo->query($sql);
foreach ($req as $row) {
    $html.='<p class="boutonC85" style="cursor:not-allowed;">'.$row['denomination'].'</p>'
            . '<div class="table-responsive">'
            . '<div id="antenne'.$row['id_antenne'].'">'
            . '<table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
            . ' <tr><th style="width:75px;">Adresse</th><td>'.$row['NomRue'].', '.$row['numero'].'</td></tr>'
            . ' <tr><th style="width:75px;">Responsable</th><td>'.$row['nom'].' '.$row['prenom'].'</td></tr>'
            . ' <tr><th style="width:75px;">T&eacute;l&eacute;phone</th><td>'.$row['telephone'].'</td></tr>'
            . ' <tr><th style="width:75px;">Fax</th><td>'.$row['fax'].'</td></tr>'
            . ' <tr><td class="info" colspan="2" style="cursor:pointer;text-align:center;" onclick="getFormEditAntenne(\''.$row['id_antenne'].'\',\''.$acces.'\',\''.$user.'\');">Modifier ces donn&eacute;es</td></tr>'
            . ' <tr><td class="danger" colspan="2" style="cursor:pointer;text-align:center;" onclick="getFormLinkQuAnt(\''.$row['id_antenne'].'\',\''.$acces.'\',\''.$user.'\');">Quartiers li&eacute;s</td></tr>'
            . '</table>'
            . '</div>'
            . '<hr>'
            . '</div>';

}
echo $html;