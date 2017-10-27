<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$idUser=\filter_input(INPUT_GET, 'user');
if(isset($idUser)){
    include('../autoload.php');
    $html='<p class="boutonC85">Donn&eacute;es dossier ville</p>'
            . '<form class="form-horizontal" name="infosAdmin">'
            . ' <div class="form-group">'
            . ' <label for="date" class="col-sm-2" control-label">Date demande</label>'
            . '     <div class="col-sm-3">'
            . '         <input type="date" class="form-control" name="date" id="date" placeHolder="Date demande">'
            . '     </div>'
            . ' </div>'
            . ' <div class="form-group">'
            . ' <label for="number" class="col-sm-2" control-label">Num&eacute;ro demande</label>'
            . '     <div class="col-sm-3">'
            . '         <input type="text" class="form-control" name="number" id="number" placeHolder="Num&eacute;ro demande">'
            . '     </div>'
            . ' </div>'
            . '</form>';
    echo $html;
}