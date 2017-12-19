<?php

class ControllerAdmin{

	private $modelAdmin;
	private $admin;
	private $max_news;
	private $url;
	private $urlAction;

	public function isAdmin(){
		return $this->admin;
	}

	function __construct($modelAdmin){
		$this->modelAdmin = $modelAdmin;
		$this->sessionID = $this->modelAdmin->getSessionAdmin();
		if($this->UpdateDB()){
			$this->reloadPage();
		}
	}

	//Verifie et modifie la base de donnees si besoin
	public function UpdateDB(){
		$reload =false;
		if($this->checkIfMaxNewsUpdated()){
			if(!$this->modelAdmin->setMaxNews($this->max_news)){
				$this->modelAdmin->setDBError(true);
			}
			$reload = true;
		}
		if($this->checkIfUrlUpdated()){
			if(!$this->modelAdmin->UpdateUrl($this->url, $this->urlAction)){
				$this->modelAdmin->setDBError(true);
			}
			$reload = true;
		}
		return $reload;
	}

  //Verifie si la valeur de la session est correcte
	public function CheckSessionID($sessionID){
		if($sessionID == $this->sessionID){
			return true;
		}
		return false;
	}

	public function CreateNewSession(){
		$_SESSION["admin"] = $this->sessionID;
	}

	//Verifie si les identifiants de l'utilisateur sont valides
	public function ValidUser($username, $password){
		if($username != null && password != null) {
			return $this->modelAdmin->isValidUser($username, $password);
		}
		return false;
	}

	//Verifie si le nombre de news maximum a ete modifie
	private function checkIfMaxNewsUpdated(){
		if(isset($_POST['max_news'])){
			$this->max_news = $_POST['max_news'];
			$this->max_news = filter_var($this->max_news, FILTER_SANITIZE_NUMBER_INT);
			return true;
		}
		return false;
	}

	//Verifie si un lien est present dans en POST
	private function checkIfUrlUpdated(){
		if(isset($_POST['url']) && !empty($_POST['url'])){
			$this->url = $_POST['url'];
			$this->url = filter_var($this->url, FILTER_VALIDATE_URL);
			if($this->rmOrAdd()){
				return true;
			}
		}
		return false;
	}

	//Verifie si le lien doit etre supprime ou ajoute
	private function rmOrAdd(){
		if(isset($_POST['contact'])){
			$this->urlAction = $_POST['contact'];

			if($this->urlAction == 'rm'){
				return true;
			}
			else if($this->urlAction = 'add'){
				return true;
			}
		}
		return false;
	}

	private function reloadPage(){
		header("Refresh:0");
	}
}
