<?php

class MEncodage extends MBase {

	private $checkDbPDO = false;

	public function __construct($appli) {
		parent::__construct($appli);
		
	}
	
	public function test(){
		$req='SELECT nom, prenom FROM users WHERE id_user="1"';;
		$rep=$this->appli->dbPdoUsers->query($req);
		while($row=$rep->fetch()){
			$nom = $row['nom'];
		}
		return $nom;
	}
	
	public function testHestia(){
		$req='SELECT test FROM test WHERE id="1"';;
		$rep=$this->appli->dbPdo->query($req);
		while($row=$rep->fetch()){
			$nom = $row['test'];
		}
		return $nom;
	}

}
?>
