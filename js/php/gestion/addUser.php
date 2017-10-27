<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$acces=\filter_input(INPUT_GET, 'acces');
$idUser=\filter_input(INPUT_GET, 'idUser');

if((isset($acces))&&(isset($idUser))){
    include('../autoload.php');
    $sql='SELECT id, denomination_grade FROM grades ORDER BY denomination_grade';
    $grade=$pdo->query($sql);
    $sql='SELECT id_service, denomination_service FROM services ORDER BY denomination_service';
    $service=$pdo->query($sql);
    //$rep->execute();
    //$grades=$rep;
    
    $html='<p class="boutonC85">Ajout d\'un utilisateur</p>'
            . '<form class="form-horizontal" role="form" name="formAddUser" method="POST" action="index.php?component=user&action=addUser">'
            . '<div class="form-group">'
            . ' <label for="Nom" class="col-sm-5 control-label">Nom</label>'
            . '     <div class="input-group">'
            . '     <input type="text" class="form-control" name="nom" id="nom" autofocus>'
            . '     </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="Prenom" class="col-sm-5 control-label">Pr&eacute;nom</label>'
            . '     <div class="input-group">'
            . '     <input type="text" class="form-control" name="prenom" id="prenom">'
            . '     </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="Matricule" class="col-sm-5 control-label">Matricule</label>'
            . '     <div class="input-group">'
            . '     <input type="text" class="form-control" name="matricule" id="matricule">'
            . '     </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="denomination_grade" class="col-sm-5 control-label">Grade</label>'
            . '     <div class="input-group">'
            . '         <select class="form-control" id="denomination_grade" name="denomination_grade">';
    foreach ($grade as $row) {
        $html.='<option value="'.$row['id'].'">'.$row['denomination_grade'].'</option>';
    }
    $html.=''
            . '         </select>'
            . '     </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="denomination_service" class="col-sm-5 control-label">Service</label>'
            . ' <div class="col-sm-5">'
            . '     <div class="input-group">'
            . '         <select class="form-control" id="denomination_service" name="denomination_service">';
    foreach($service as $row){
        $html.='<option value="'.$row['id_service'].'">'.$row['denomination_service'].'</option>';
    }
    $html.=''
            . '         </select>'
            . '     </div>'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="mail" class="col-sm-5 control-label">Mail</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="mail" name="mail">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="fixe" class="col-sm-5 control-label">T&eacute;l&eacute;phone fixe</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="fixe" name="fixe">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="gsm" class="col-sm-5 control-label">GSM</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="gsm" name="gsm">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="CP" class="col-sm-5 control-label">Code postal</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="CP" name="CP">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="ville" class="col-sm-5 control-label">Ville</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="ville" name="ville">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="rue" class="col-sm-5 control-label">Rue</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="rue" name="rue">'
            . ' </div>'
            . '</div>'
            . '<div class="form-group">'
            . ' <label for="numero" class="col-sm-5 control-label">Num&eacute;ro</label>'
            . ' <div class="input-group">'
            . '     <input type="text" class="form-control" id="numero" name="numero">'
            . ' </div>'
            . '</div>'
            . '<div class="col-sm-offset-5 col-sm-10">'
            . '    <button type="submit" class="btn btn-default">Enregistrer</button>'
            . '</div>'
            . '</form>';
        
}
else $html='Vous ne pouvez acc&eacute;der &agrave cette partie du site ou votre session a expir&eacute;';

echo $html;