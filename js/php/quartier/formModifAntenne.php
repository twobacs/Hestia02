<?php

/*
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idAntenne= \filter_input(INPUT_GET, 'idAntenne');
$acces= \filter_input(INPUT_GET, 'acces');
$user= \filter_input(INPUT_GET, 'user');

include ('../autoload.php');

$sql='SELECT id_antenne, IdRue, numero, telephone, fax, id_resp FROM z_antenne_quartier WHERE id_antenne=:idAntenne';
$req=$pdo->prepare($sql);
$req->bindValue('idAntenne',$idAntenne,PDO::PARAM_INT);
$req->execute();
foreach ($req as $row) {
   $idRue=$row['IdRue'];
   $num=$row['numero'];
   $tel=$row['telephone'];
   $fax=$row['fax'];
   $idResp=$row['id_resp'];
}

$sql='SELECT IdRue, NomRue FROM z_rues ORDER BY NomRue';
$req=$pdo->query($sql);
$selectRues='<select class="form-control" name="rue" id="rue">';
foreach($req as $row){
    $selectRues.='<option value="'.$row['IdRue'].'"';
    if($row['IdRue']==$idRue){
      $selectRues.=' selected';
    }
    $selectRues.='>'.$row['NomRue'].'</option>';
}
$selectRues.='</select>';

$sql='SELECT id_user, nom, prenom FROM users WHERE actif="O" ORDER BY nom, prenom';
$req=$pdo->query($sql);
$selectUser='<select class="form-control" name="user" id="user">';
foreach($req as $row){
    $selectUser.='<option value="'.$row['id_user'].'"';
    if($row['id_user']==$idResp){$selectUser.=' selected';}
    $selectUser.='>'.$row['nom'].' '.$row['prenom'].'</option>';
}
$selectUser.='</select>';
$html='<form><table class="table table-hover" style="margin-left:75px;max-width:745px;">'
        . ' <tr><th style="width:75px;">Adresse</th><td>'.$selectRues.'</td><th>Num&eacute;ro</th><td><input class="form-control" type="text" name="newNum" id="newNum" value="'.$num.'"></td></tr>'
        . ' <tr><th style="width:75px;">Responsable</th><td colspan="3">'.$selectUser.'</td></tr>'
        . ' <tr><th style="width:75px;">T&eacute;l&eacute;phone</th><td colspan="3"><input class="form-control" type="tel" name="newTel" id="newTel" title="Au format international (ex : +3256863000)" value="'.$tel.'" required onfocusout="phonenumber(\'newTel\',\'FB\');"></td></tr>'
        . ' <tr><th style="width:75px;">Fax</th><td colspan="3"><input class="form-control" type="text" name="newFax" id="newFax" value="'.$fax.'"></td></tr>'
        . ' <tr><td class="warning" colspan="4" style="cursor:pointer;text-align:center;" onclick="recordEditAntenne(\''.$idAntenne.'\',\''.$acces.'\',\''.$user.'\');">Enregistrer ces donn&eacute;es</td></tr>'
        . '</table></form>';
echo $html;
