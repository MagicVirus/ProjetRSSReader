<?php

require_once (__ROOT__.'/database/database.php');

class Gateway{
	private $d = null;

	function __construct(){
		$this->d = new Database();
	}

	public function GetSessionAdmin(){
	    $sql = "SELECT sessionAdmin FROM Settings";
	    $result =  $this->d->ExecQuery($sql);

	    if(!empty($result)){
	        return $result;
        }
        return null;
    }

	public function ValidCreditentials($usr, $pswd){
    $sql = "SELECT username, password FROM Settings";
    $result= $this->d->ExecQuery($sql);

    $row = $result->fetch_assoc();

    if($row['username'] == $usr && $row['password'] == $pswd){
        return true;
    }
        return false;
    }

    public function GetUrls(){
    $sql = "SELECT url FROM Feed";
    $row = $this->d->ExecQuery($sql);

    if ($row->num_rows > 0) {
      return $row;
    }
    return null;
    }

    public function GetMaxNews(){
        $sql = "SELECT max_news FROM Settings";
        $result = $this->d->ExecQuery($sql);

        if ($result->num_rows > 0){
          $row = $result->fetch_assoc();
          return $row["max_news"];
        }
        else {
          return 10;
        }
    }

    public function SetMaxNews($max_news){
        $sql = "UPDATE Settings SET max_news = $max_news WHERE Settings.username = 'admin'";
        return $this->d->ExecQuery($sql);
    }

    public function AddUrl($url){
        $url = '"' . $url . '"';
        $sql = "INSERT INTO Feed (url) VALUES($url)";
        return $this->d->ExecQuery($sql);
    }

    public function RmUrl($url){
        $url = '"' . $url . '"';
        $sql = "DELETE FROM Feed WHERE Feed.url = $url";
        return $this->d->ExecQuery($sql);
    }
}