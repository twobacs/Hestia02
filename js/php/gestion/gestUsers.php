<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$acces=\filter_input(INPUT_GET, 'acces');
$idUser=\filter_input(INPUT_GET, 'idUser');

if(isset($acces)){
    include('../autoload.php');
    $html='<p class="boutonC85" style="cursor:default;">Gestion des utilisateurs</p>';
    $html.='<p class="boutonC45" style="cursor:pointer;" onclick="addUser(\''.$acces.'\',\''.$idUser.'\');">Ajouter un utilisateur</p>';
    $sql='SELECT id,id_user,acces FROM Hestia_Acces';
    $req=$pdo->query($sql);
    $niv15=array();
    $niv10=array();
    $niv5=array();
    $niv1=array();
    $config=array();
    $niv0=array();
    foreach($req as $row){
        $sqla='SELECT id_user, login, nom, prenom, denomination_grade FROM users WHERE id_user=:idUser';
        $reqa=$pdo->prepare($sqla);
        $reqa->bindValue('idUser',$row['id_user'], PDO::PARAM_INT);
        $reqa->execute();            
        foreach($reqa as $rowa){
            if($row['acces']=='15'){
                array_push($niv15, '<tr id="'.$rowa['id_user'].'"><td>'.$rowa['nom'].'</td><td>'.$rowa['prenom'].'</td><td>'.$rowa['denomination_grade'].'</td><td>'.$rowa['login'].'</td><td width="5px" style="text-align:center;cursor:pointer;" onclick="editUserHestia(\''.$rowa['id_user'].'\');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></td></tr>');
            }
            else if($row['acces']=='10'){
                array_push($niv10, '<tr id="'.$rowa['id_user'].'"><td>'.$rowa['nom'].'</td><td>'.$rowa['prenom'].'</td><td>'.$rowa['denomination_grade'].'</td><td>'.$rowa['login'].'</td><td width="5px" style="text-align:center;cursor:pointer;" onclick="editUserHestia(\''.$rowa['id_user'].'\');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></td></tr>');
            }
            else if($row['acces']=='5'){
                array_push($niv5, '<tr id="'.$rowa['id_user'].'"><td>'.$rowa['nom'].'</td><td>'.$rowa['prenom'].'</td><td>'.$rowa['denomination_grade'].'</td><td>'.$rowa['login'].'</td><td width="5px" style="text-align:center;cursor:pointer;" onclick="editUserHestia(\''.$rowa['id_user'].'\');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></td></tr>');
            }
            else if($row['acces']=='1'){
                array_push($niv1, '<tr id="'.$rowa['id_user'].'"><td>'.$rowa['nom'].'</td><td>'.$rowa['prenom'].'</td><td>'.$rowa['denomination_grade'].'</td><td>'.$rowa['login'].'</td><td width="5px" style="text-align:center;cursor:pointer;" onclick="editUserHestia(\''.$rowa['id_user'].'\');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></td></tr>');
            }
            array_push($config,$rowa['id_user']);
        }
    }
    $sqlb='SELECT id_user, login, nom, prenom, denomination_grade FROM users WHERE actif="O"';
    $reqb=$pdo->query($sqlb);
    foreach ($reqb as $rowb){
        if(!in_array($rowb['id_user'],$config)){
            array_push($niv0, '<tr id="'.$rowb['id_user'].'"><td>'.$rowb['nom'].'</td><td>'.$rowb['prenom'].'</td><td>'.$rowb['denomination_grade'].'</td><td>'.$rowb['login'].'</td><td width="5px" style="text-align:center;cursor:pointer;" onclick="editUserHestia(\''.$rowb['id_user'].'\');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></td></tr>');
        }
    }
    $tr='<table class="table table-bordered"><tr class="active"><th width="120px">Nom</th><th width="120px">Pr&eacute;nom</th><th width="120px">Grade</th><th width="120px">Identifiant</th></tr>';
    sort($niv15);        
    $htmlniv15='<p class="boutonC45" style="cursor:help;" onclick="alert(\'Chef service proximité\nSecrétariat quartier\nMembre désigné par le chef de corps\');">Utilisateurs niveau 1</p>';
    $htmlniv15.=$tr;
    for($i=0;$i<sizeof($niv15);$i++){
        $htmlniv15.=$niv15[$i];
    }
    $htmlniv15.='</table>';
    
    sort($niv10);
    $htmlniv10='<p class="boutonC45" style="cursor:help;" onclick="alert(\'Responsable antenne\');">Utilisateurs niveau 2</p>';
    $htmlniv10.=$tr;
    for($i=0;$i<sizeof($niv10);$i++){
        $htmlniv10.=$niv10[$i];
    }
    $htmlniv10.='</table>';
    
    sort($niv5);
    $htmlniv5='<p class="boutonC45" style="cursor:help;" onclick="alert(\'Agent de quartier\');">Utilisateurs niveau 3</p>';
    $htmlniv5.=$tr;
    for($i=0;$i<sizeof($niv5);$i++){
        $htmlniv5.=$niv5[$i];
    }
    $htmlniv5.='</table>';
    
    sort($niv1);
    $htmlniv1='<p class="boutonC45" style="cursor:help;" onclick="alert(\'Autre membre du personnel (Consultation uniquement)\');">Utilisateurs niveau 4</p>';
    $htmlniv1.=$tr;
    for($i=0;$i<sizeof($niv1);$i++){
        $htmlniv1.=$niv1[$i];
    }
    $htmlniv1.='</table>';
    
    sort($niv0);
    $htmlniv0='<p class="boutonC45" style="cursor:help;" onclick="alert(\'Aucun acc&egrave;s configur&eacute;\');">Aucun acc&egrave;s configur&eacute;</p>';
    $htmlniv0.=$tr;
    for($i=0;$i<sizeof($niv0);$i++){
        $htmlniv0.=$niv0[$i];
    }
    $html.='</table>';
    
    if($acces==='15'){
        $html.=$htmlniv15.$htmlniv10.$htmlniv5.$htmlniv1.$htmlniv0;
    }
    else{
        $html.='Vous ne pouvez acc&eacute;der &agrave; cette parie du site.';
    }
    echo $html;
}

