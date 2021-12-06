<?php 

require_once('controllers/MainController.controller.php');
require_once('models/Visiteur/visiteur.model.php');

class VisiteurController extends MainController
{
    private $visiteurManager;

    public function __construct()
    {
        $this->visiteurManager = new VisiteurManager();
    }
    //Propriété "page_css" : tableau permettant d'ajouter des fichiers CSS spécifiques
    //Propriété "page_javascript" : tableau permettant d'ajouter des fichiers JavaScript spécifiques
    public function accueil(){
        
        // Toolbox::ajouterMessageAlerte("test", Toolbox::COULEUR_VERTE);
        //echo password_hash('EVR1082van',PASSWORD_DEFAULT);
        $data_page = [
            "page_description" => "Description de la page d'accueil",
            "page_title" => "Titre de la page d'accueil",
            "view" => "views/visiteur/accueil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function login()
    {
        $data_page = [
            "page_description" => "Page de connexion",
            "page_title" => "Page de connexion",
            "view" => "views/visiteur/login.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);  // pour generer les pages
    }

    public function register()
    {
        $data_page = [
            "page_description" => "Page creer compte",
            "page_title" => "Page creer compte",
            "view" => "views/visiteur/register.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);

    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
        // faire appel la function de la class parent
    }
}