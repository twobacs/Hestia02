<?php

class MUser extends MBase {

	private $checkDbPDO = false;

	public function __construct($appli) {
		parent::__construct($appli);
		
	}
    
    public function login($u,$p){
        include_once('./class/user.class.php');
        $user=new User($this->appli->dbPdo);
        $data=$user->login($u,$p);  
        if(is_array($data)){
            $data['acces']=$this->getAccess($data['idUser']);
            $_SESSION['idUser']=$data['idUser'];
            $_SESSION['acces']=$data['acces'];
            $_SESSION['prenom']=$data['prenom'];
            }
        return $data;
        }
        
    public function getAccess($id){
        $req=$this->appli->dbPdo->prepare('SELECT acces FROM Hestia_Acces WHERE id_user=:id');
        $req->bindValue('id',$id,  PDO::PARAM_INT);
        $req->execute();
        foreach($req as $row){
            $acces=$row['acces'];
        }
        
        if($acces==='5'){
            //agt Quartier
            //$sql='SELECT ';
        }
        if($acces==='10'){
            //chef antenne
        }
        if($acces==='15'){
            //Dieu
        }
        return $acces;
    }
    
    public function getInfosUserById($idUser){
        $sql='SELECT '
                . 'a.login, a.nom, a.prenom, a.matricule, a.mail, a.fixe, a.gsm, a.CP, a.ville, a.rue, a.numero, a.naissance, a.denomination_grade, '
                . 'b.denomination_service '
                . 'FROM users a '
                . 'LEFT JOIN services b ON b.id_service = a.id_service '
                . 'WHERE a.id_user=:idUser';
        $req=$this->appli->dbPdo->prepare($sql);
        $req->bindValue('idUser',$idUser, PDO::PARAM_INT);
        $req->execute();
        return $req;
    }
    
    public function getGrades(){
        $sql='SELECT id, denomination_grade FROM grades';
        $req=$this->appli->dbPdo->prepare($sql);
        $req->execute();
        return $req;
    }
    
    public function getServices(){
        $sql='SELECT id_service, denomination_service FROM services';
        $req=$this->appli->dbPdo->prepare($sql);
        $req->execute();
        return $req;
    }
    
    public function updateUser(){
        include ('./class/user.class.php');
        $user=new User($this->appli->dbPdo,$this->appli->dbPdo);
        return $user->updateUser($_POST,$_GET['user']);
    }
    
    public function addUser(){
        include ('./class/user.class.php');
        $user=new User($this->appli->dbPdo,$this->appli->dbPdo);
        return $user->addUser($_POST,$_GET['user']);
    }
        	
}
?>