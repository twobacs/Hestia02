<?php

class User
{
public $idUser;
public $login;
public $nom;
public $prenom;
public $matricule;
public $lateralite;
public $uniformise;
public $sexe;
public $grade;
public $mdp;
public $type;
public $mail;
public $service;
public $points;
public $actif;
public $logError;
public $idEval;
public $fixe;
public $gsm;
public $fax;
public $CP;
public $commune;
public $rue;
public $numero;
public $naissance;
public $rrn;
private $pdo;

public function __construct($dbPdo)
	{
	$this->pdo = $dbPdo;        
	}

function login($u, $p){
    $sql='SELECT id_user, nom, prenom, log_error FROM users WHERE login=:login AND mdp_user=:mdp';
    $req=$this->pdo->prepare($sql);
    $req->bindValue('login',$u, PDO::PARAM_STR);
    $req->bindValue('mdp',md5($p), PDO::PARAM_STR);
    $req->execute();
    $c=$req->rowCount();
   switch($c){
        case 0:
            return $this->add_log_error($u,$p);
            break;
        case 1:
            foreach($req as $row){
            $data['idUser']=$row['id_user'];
            $data['nom']=$row['nom'];
            $data['prenom']=$row['prenom'];            
            }
            $req=$this->pdo->prepare('UPDATE users SET log_error="0" WHERE id_user=:user');
            $req->bindValue('user',$data['idUser'],PDO::PARAM_INT);
            $req->execute();
            return $data;
            break;
   }
   
}

function add_log_error($u,$p){
    $req=$this->pdo->prepare('SELECT log_error FROM users WHERE login=:login');
    $req->bindValue('login',$u, PDO::PARAM_STR);
    $req->execute();
    $c=$req->rowCount();
    if($c==1){   
        foreach($req as $row){
            $nbE=$row['log_error'];
            $nbE++;
        }
        if($nbE<4){
            $req=$this->pdo->prepare('UPDATE users SET log_error="'.$nbE++.'" WHERE login=:login');
            $req->bindValue('login',$u, PDO::PARAM_STR);
            $req->execute();
            $rep=1;    //Erreur mais compte non bloqué            
        }
        else {$rep=3;}   //Erreur compte bloqué
    }
    else {$rep=2;} //Login inexistant
    $this->add_entry_err($u,$p);
    return $rep;    
}

function add_entry_err($u,$p){
    $date=date("y-m-d");
    $time=date("H:i:s");
    $ip_client=$_SERVER['REMOTE_ADDR'];
    $id_machine=   gethostbyaddr($ip_client);
    $login_used=$u;
    $pass_used=$p;
    $req=$this->pdo->prepare('INSERT INTO Hestia_entry_error (date,heure,ip_client,id_machine,login_used,pass_used) VALUES (:date,:heure,:ip,:idM,:idU,:pass)');
    $req->bindValue(':date',$date, PDO::PARAM_STR);
    $req->bindValue(':heure',$time, PDO::PARAM_STR);
    $req->bindValue(':ip',$ip_client, PDO::PARAM_STR);
    $req->bindValue(':idM',$id_machine, PDO::PARAM_STR);
    $req->bindValue(':idU',$login_used, PDO::PARAM_STR);
    $req->bindValue(':pass',$pass_used, PDO::PARAM_STR);
    $req->execute();    
}

public function updateUser($post,$idUser,$insert=0){
    $nom=$post['nom'];
    $prenom=$post['prenom'];
    $matricule=$post['matricule'];
    $grade=$post['denomination_grade'];
    $service=$post['denomination_service'];
    $mail=$post['mail'];
    $fixe=$post['fixe'];
    $gsm=$post['gsm'];
    $CP=$post['CP'];
    $ville=$post['ville'];
    $rue=$post['rue'];
    $numero=$post['numero'];
    $sql='UPDATE users SET nom=:nom, prenom=:prenom, matricule=:matricule, denomination_grade=:grade, id_service=:service, '
            . 'mail=:mail, fixe=:fixe, gsm=:gsm, CP=:CP, ville=:ville, rue=:rue, numero=:num WHERE id_user=:idUser ';
    if ($insert==='insert'){
        $sql='INSERT INTO users (nom, prenom, matricule, denomination_grade, id_service, mail, fixe, gsm, CP, ville, rue, numero)'
                . 'VALUES (:nom, :prenom, :matricule, :grade, :service, :mail, :fixe, :gsm, :CP, :ville, :rue, :num)';
    }
    $req=$this->pdo->prepare($sql);
    $req->bindValue('nom',$nom,  PDO::PARAM_STR);
    $req->bindValue('prenom',$prenom,  PDO::PARAM_STR);
    $req->bindValue('matricule',$matricule,  PDO::PARAM_STR);
    $req->bindValue('grade',$grade,  PDO::PARAM_STR);
    $req->bindValue('service',$service,  PDO::PARAM_STR);
    $req->bindValue('mail',$mail,  PDO::PARAM_STR);
    $req->bindValue('fixe',$fixe,  PDO::PARAM_STR);
    $req->bindValue('gsm',$gsm,  PDO::PARAM_STR);
    $req->bindValue('CP',$CP,  PDO::PARAM_STR);
    $req->bindValue('ville',$ville,  PDO::PARAM_STR);
    $req->bindValue('rue',$rue,  PDO::PARAM_STR);
    $req->bindValue('num',$numero,  PDO::PARAM_STR);
    if($insert===0){
        $req->bindValue('idUser',$idUser,  PDO::PARAM_STR);
    }
    $req->execute();
    return $req->rowCount();    
}

public function addUser($post,$idUser){
    $this->updateUser($post, $idUser,'insert');
}
}
?>