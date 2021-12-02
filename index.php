<?php
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
"://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"])); // constant URL pour que tout le fichier ponter sur la racine

require_once("./controllers/Visiteur/visiteur.controller.php");
$visiteurController = new VisiteurController(); // controller pour pilote tout le pages du site

try {
    if(empty($_GET['page'])){
        // gestion de routage
        $page = "accueil"; // s'il est vide on indique que c'est la page d'accueil
    } else {
        $url = explode("/", filter_var($_GET['page'],FILTER_SANITIZE_URL));
        //explose i'information dans url avec / nous permet d'avoir acces a des sous dossiers avec un tableau
        $page = $url[0];
    }

    switch($page){
        case "accueil" : $visiteurController->accueil();
        break;
        case "login" : $visiteurController->login();
        break;
        case "validation_login" : echo $_POST['login'] . ' ' . $_POST['password'] ;
        break;
        case "compte" : 
            switch($url[1]){
                case "profil": $visiteurController->accueil();
                break;
            }
        break;
        default : throw new Exception("La page n'existe pas"); //expection
    }
} catch (Exception $e){
    $visiteurController->pageErreur($e->getMessage()); //page pour gerer les erreurs
}