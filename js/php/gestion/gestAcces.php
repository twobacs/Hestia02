<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

$acces=\filter_input(INPUT_GET, 'acces');

if(isset($acces)){
    include('../autoload.php');
    $html='<p class="boutonC85">Gestion des acc&egrave;s</p>';
    
    //Présenter un tableau avec radio button correspondant à l'accès octroyé
    
    $sql='SELECT id_user, nom, prenom FROM users ORDER BY nom, prenom';
    $users=$pdo->query($sql);
    
    $usersdroits=array();
    $i=0;
    $j=0;
    
    foreach($users as $row){
        $usersdroits[$i]['id_user']=$row['id_user'];
        $usersdroits[$i]['nom']=$row['nom'].' '.$row['prenom'];
        $usersdroits[$i]['droit']=0;
        $i++;
    }    
    
    $sql='SELECT id, id_user, acces FROM Hestia_Acces';
    $droits=$pdo->query($sql);
    
    foreach($droits as $row){
        for($j=0;$j<=$i;$j++){
            if($row['id_user']==$usersdroits[$j]['id_user']){
                $usersdroits[$j]['droit']=$row['acces'];
            }
        }
    }
    
    //print_r($usersdroits);
    
    $html.='<table class="table table-bordered table-hover" style="width:550px;">'
            . '<tr><th style="width:250px;"></th>'
            . '<th style="width:35px;cursor:help;background-color:#cccccc" onclick="alert(\'Chef service proximité\nSecrétariat quartier\nMembre désigné par le chef de corps\');">N 1</th>'
            . '<th style="width:35px;cursor:help;background-color:#cccccc"" onclick="alert(\'Responsable antenne\');">N 2</th>'
            . '<th style="width:35px;cursor:help;background-color:#cccccc"" onclick="alert(\'Agent de quartier\');">N 3</th>'
            . '<th style="width:35px;cursor:help;background-color:#cccccc"" onclick="alert(\'Autre membre du personnel (Consultation uniquement)\');">N 4</th>'
            . '<th style="width:35px;cursor:help;background-color:#cccccc"" onclick="alert(\'Aucun acc&egrave;s configur&eacute;\');">NC</th></tr>';
            for($k=0;$k<$i;$k++){
                switch(intval($usersdroits[$k]['droit'])){
                    case 0:
                        $html.='<tr><th>'.$usersdroits[$k]['nom'].'</th>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'15\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'10\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'5\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'1\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td bgcolor="#36aa27" style="cursor:not-allowed;"></td></tr>';
                        break;
                    case 1:
                        $html.='<tr><th>'.$usersdroits[$k]['nom'].'</th>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'15\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'10\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'5\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td bgcolor="#36aa27" style="cursor:not-allowed;"></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'0\',\''.$usersdroits[$k]['id_user'].'\')";></td></tr>';
                        break;
                    case 5:
                        $html.='<tr><th>'.$usersdroits[$k]['nom'].'</th>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'15\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'10\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td bgcolor="#36aa27" style="cursor:not-allowed;"></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'1\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'0\',\''.$usersdroits[$k]['id_user'].'\')";></td></tr>';
                        break;
                    case 10:
                        $html.='<tr><th>'.$usersdroits[$k]['nom'].'</th>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'15\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td bgcolor="#36aa27" style="cursor:not-allowed;"></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'5\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'1\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'0\',\''.$usersdroits[$k]['id_user'].'\')";></td></tr>';
                        break;
                    case 15:
                        $html.='<tr><th>'.$usersdroits[$k]['nom'].'</th>'
                            . '<td bgcolor="#36aa27" style="cursor:not-allowed;"></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'10\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'5\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'1\',\''.$usersdroits[$k]['id_user'].'\')";></td>'
                            . '<td style="cursor:pointer;" onclick="attribDroits(\'0\',\''.$usersdroits[$k]['id_user'].'\')";></td></tr>';
                        break;
                    default:
                        $html.='<tr><th>ca marche pas</th></tr>';
                        break;
                }
            }
    $html.='</table>';

    echo $html;
}