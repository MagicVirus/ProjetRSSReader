<?php

session_start();

require_once 'controllers/admin.php';
require_once 'models/admin.php';
require_once 'views/admin.php';

$modelAdmin = new ModelAdmin();
$controllerAdmin = new ControllerAdmin($modelAdmin);


//Si la session est ouverte
if(!empty($_SESSION["admin"]) && $controllerAdmin->CheckSessionID($_SESSION["admin"])){
    $viewAdmin = new AdminView($controllerAdmin, $modelAdmin);
    echo $viewAdmin->output();
}

//Si les donnees envoyees par POST correspondent aux identifiants
elseif(!empty($_POST["username"]) && $controllerAdmin->ValidUser($_POST['username'], $_POST['password'])){
    //assigne une session
    $controllerAdmin->CreateNewSession();
    $viewAdmin = new AdminView($controllerAdmin, $modelAdmin);
    echo $viewAdmin->output();
}
//On renvoie l'user sur la page index.php avec une erreur
else{
    $viewAdmin = new AdminView($controllerAdmin, $modelAdmin);
    $viewAdmin->Homepage("?err"); //avec ?err en parmetre
}