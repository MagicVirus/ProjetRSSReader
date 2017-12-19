<?php

class NewsView {

  private $controllerNews;
  private $modelNews;
  private $idError = "idError";

  function __construct($controllerNews, $modelNews){
    $this->controllerNews = $controllerNews;
    $this->modelNews = $modelNews;
  }

  private function generateTop(){
    if(!$this->controllerNews->getAdmin()){
      include(__ROOT__ . '/layouts/indexTopLogin.html');
      //return 'login';
    }
    else{
      include (__ROOT__.'/layouts/indexTopAdmin.html');
      //return 'admin';
    }
  }

  private function generateNotif(){
    if($this->controllerNews->getError() == $this->idError) {
      return '<h3 class="channel-title"><p align="center">Credentials error, try again !<p></h3>';
    }

    if($this->controllerNews->getDisconnected()){
      return '<h3 class="channel-title"><p align="center">Disconnected succesfully !<p></h3>';
    }
  }

  private function generateBottom(){
    $string = null;
    //Recuperation du tableau de flux
    $rssArray = $this->modelNews->getrssXMLArray();
    $i = count($rssArray); //Nombre de flux dans le tableau

    for($i; $i >= 0; $i--){ //Parcourir le tableau de flux
      $j = 0;
      $rss = $rssArray[$i];

      //Affiche le nom de la chaine en titre au dessus de ses news
      $string .= '<div class="container"><div class="properties-news"><h1 align="center" class ="channel-title">'.$rss->channel->title.'</h1>';

      //Affiche chaque news du flux
      foreach($rss->channel->item as $item) {
        if ($j < $this->modelNews->getMaxNews()) { // Max news c'est le nombre max de news a afficher pour chaque flux
          $num=$j+1;
          $string .= '<div class="news-article"><h3 class="sub-channel-title">Article ' .$num.' of '.$rss->channel->title.'</h3>';
          $string .= '<a href="'.$item->link.'">'.$item->title.'</a><br />';
          $string .= '<p>' .$item->pubDate.'<p>';
          $string .= '<p class="news-description">' .$item->description.'</p><br/><br/>';
          $num=$j+1;
        }
        $j++;
         $string .='</div>';
      }
      $string .='<div>
            <p><br/>
            </p>
          </div>
          </div>
        </div>
      </div>';
     
    }
    $string .=' </body>
    </html> ';
    return $string;
  }

  public function output(){
    return $this->generateTop() . $this->generateNotif() . $this->generateBottom();
  }

}
