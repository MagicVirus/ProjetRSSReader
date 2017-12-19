<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/database/gateway.php');

class ModelAdmin{

  private $DBError = null;
	private $maxNews;
	private $urls;
 	private $gateway = null;
 	private $sessionAdmin;

 	public function getSessionAdmin(){
    return $this->sessionAdmin;
	}

  public function setDBError($bool){
    $this->DBError = $bool;
  }

	public function getUrls(){
  	return $this->urls;
  }

	public function getMaxNews(){
   	return $this->maxNews;
  }

	public function setMaxNews($max_news){
		$this->max_news = $max_news;
		return $this->gateway->SetMaxNews($max_news);
	}

	public function isValidUser($usr, $pswd){
		return ($this->gateway->validCredentials($usr,$pswd));
	}

	function __construct(){
    $this->gateway = new Gateway();
    $this->sessionAdmin = $this->gateway->GetSessionAdmin();
    $this->maxNews = $this->gateway->getMaxNews();
    $this->urls = $this->gateway->getUrls();
    if($this->sessionAdmin == null){
        $this->DBError = true;
    }
	}

	public function UpdateUrl($url, $action){
		if($action == 'add'){
			return $this->gateway->AddUrl($url);
		}
		return $this->gateway->RmUrl($url);
	}
}
