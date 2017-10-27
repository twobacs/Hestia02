<?php

include('../autoload.php');
$name= \filter_input(INPUT_GET, 'name');
$surname= \filter_input(INPUT_GET, 'surname');
$birth= \filter_input(INPUT_GET, 'birth');

if(isset($name)){
    $req=$pdo->prepare('SELECT COUNT(*), id FROM Hestia_Personne WHERE Nom=:name AND Prenom=:surname AND DateNaissance=:birth');
    $req->bindValue('name',$name,  PDO::PARAM_STR);
    $req->bindValue('surname',$surname,  PDO::PARAM_STR);
    $req->bindValue('birth',$birth, PDO::PARAM_STR);
    $req->execute();
    foreach($req as $row){
        $count=$row['COUNT(*)'];
        $idP=(isset($row['id']))?$row['id']:null;        
    }
    
if($idP){
    $req=$pdo->prepare('SELECT GSM, Profession FROM Hestia_Personne WHERE id=:id');
    $req->bindValue('id',$idP,  PDO::PARAM_INT);
    $req->execute();
    foreach($req as $row){
        $data['mobile']=$row['GSM'];
        $data['profession']=ucfirst($row['Profession']);
    }
    if($data['Profession']!==''){
        $req=$pdo->prepare('SELECT Nom, Tel FROM Hestia_Employeur WHERE id=(SELECT id_Emp FROM Pers_Emp WHERE id_Pers=:id)');
        $req->bindValue('id',$idP,  PDO::PARAM_INT);
        $req->execute();
        foreach($req as $rowa){
            $data['employeur']=(isset($rowa['Nom']))?$rowa['Nom']:'';
            $data['TelEmp']=(isset($rowa['Tel']))?$rowa['Tel']:'';
        }
    }
    $req1=$pdo->prepare('SELECT COUNT(*), a.id, a.DateIn, b.id_commune, b.id_rue, b.Numero '
            . 'FROM Hestia_Pers_Bat a '
            . 'LEFT JOIN Hestia_Batiment b ON b.id=a.id_Bat '
            . 'WHERE a.id_Pers=:pers AND a.actif="O"');
    $req1->bindValue('pers',$idP,  PDO::PARAM_INT);
    $req1->execute();
    foreach ($req1 as $row1){
        $req2=$pdo->prepare('SELECT zip, name FROM cities WHERE id=:idCity');
        $req2->bindValue('idCity',$row1['id_commune'],  PDO::PARAM_INT);
        $req2->execute();
        foreach($req2 as $row2){
            $data['oldZip']=$row2['zip'];
            $data['oldCity']=$row2['name'];
        }
        $req3=$pdo->prepare('SELECT NomRue FROM z_rues WHERE IdRue=:idrue');
        $req3->bindValue('idrue',$row1['id_rue'],  PDO::PARAM_INT);
        $req3->execute();
        foreach ($req3 as $row3) {
            $data['oldStreet']=$row3['NomRue'];
        }
        $data['oldNumber']=$row1['Numero'];
        $data['idPersBat']=$row1['id'];
        $data['DateIn']=$row1['DateIn'];
    }
    
}

else{
   $data['mobile']='';
   $data['profession']='';
   $data['employeur']='';
   $data['TelEmp']='';
    }
echo json_encode($data);
//    print_r($data);

//exit;
}
