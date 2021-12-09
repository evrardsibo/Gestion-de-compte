<?php
require_once('./controllers/MainController.controller.php');
require_once('./controllers/securite.class.php');
require_once('./controllers/Toolbox.class.php');
require_once('./models/Administrateur/admin.model.php');

class adminController extends MainController
{
    private $adminManager;
    public function __construct()
    
    {
        $this->adminManager = new adminManager();
    }

    public function droits()
    {
        $utilisateur = $this->adminManager->getUtilisateurs();
        $data_page = [
            "page_description" => "Description Admin",
            "page_title" => "Titre de la page admin",
            "utilisateur" => $utilisateur,
            "page_javascript" => ['profil.js'],
            "view" => "views/Administrateur/admin.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function validationRole($login,$role)
    {
        if($this->adminManager->validationBdRole($login,$role))
        {
            Toolbox::ajouterMessageAlerte('role bien modifie',Toolbox::COULEUR_VERTE);
        }else
        {
            Toolbox::ajouterMessageAlerte('role non modifie',Toolbox::COULEUR_ROUGE);
            
        }
        header('Location'.URL.'administration/droits');
        ;
    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
        // faire appel la function de la class parent
    }
}