<?php

/* 
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */
$CP=\filter_input(INPUT_GET, 'CP');
$idOwner=\filter_input(INPUT_GET, 'idOwner');

if(isset($CP)){
    if($idOwner){
        $idName="City_".$idOwner;
    }
    else $idName="Ville";
    include('../autoload.php');
    $req=$pdo->prepare('SELECT id, name, zip FROM cities WHERE zip=:CP');
    $req->bindValue('CP',$CP,  PDO::PARAM_INT);
    $req->execute();
    $count=$req->rowcount();
    if($count>1){        
        $html='<select class="form-control" name="'.$idName.'" id="'.$idName.'"><option disabled selected value="-1">Veuillez s&eacute;lectionner</option>';
        foreach($req as $row){
            $html.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        $html.='</select>';
    }
    else{
        foreach($req as $row){
            $html='<input disabled type="text" class="form-control" id="'.$idName.'" placeHolder="Ville" value="'.strtoupper($row['name']).'">';
        }
    }
    
}
else if((isset($CP))&&(isset($idOwner))){
    $html='pouet';
}

echo $html;
?>