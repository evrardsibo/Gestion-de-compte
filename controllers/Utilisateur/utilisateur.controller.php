<?php 

require_once('controllers/MainController.controller.php');
require_once('models/Visiteur/visiteur.model.php');
require_once('models/Utilisateur/ulitisateur.model.php');


class UlitisateurController extends MainController
{
    private $UtilisateurManager;

    public function __construct()
    {
        $this->UtilisateurManager = new utilisateurManager();
    }
    
    
    public function validation_login($login, $password)
    {
        if($this->UtilisateurManager->isCombinaisonValide($login, $password))
        {
            if($this->UtilisateurManager->estCompteActive($login))
            {
                Toolbox::ajouterMessageAlerte('Bienvenu sur ton profil'. ' ' .$login . '!' , Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    'login' => $login
                ];
                header('Location:' . URL . 'compte/profil');
            }else
            {
                $msg = "le compte" . ' ' . $login . ' '. "n'est pas activé" . ' ';
                $msg .= "<a href='renvoyerMailValidation/".$login."'>Renvoyez le mail de validation</a>";

                Toolbox::ajouterMessageAlerte($msg,Toolbox::COULEUR_ROUGE);
            header('Location:' . URL . 'login');
            }
        }else
        {
             Toolbox::ajouterMessageAlerte('login et mot de passe non valide',Toolbox::COULEUR_ROUGE);
            header('Location:' . URL . 'login');
        }
    }
    public function profil()
    {
        $datas = $this->UtilisateurManager->getUserinformation($_SESSION['profil']['login']);
        //print_r($datas); // voir si on accede au donne
       // $_SESSION['profil']['role'] = $datas['role'];
        $data_page = [
            "page_description" => "Description profil",
            "page_title" => "Titre de la page de profil",
            "utilisateur" => $datas,
            "page_javascript" => ['profil.js'],
            "view" => "views/Utilisateur/profil.views.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function deconnexion()
    {
        Toolbox::ajouterMessageAlerte('Vous etes deconnecté',Toolbox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        header('location:' . URL . 'accueil');

    }

    public function validation_creerCompte($login,$password,$mail)
    {
        if($this->UtilisateurManager->VerifierloginDispo($login))
        {
            $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
            $clef = rand(0,9999);
            if($this->UtilisateurManager->bdCreercompte($login,$passwordCrypte,$mail,$clef))
            {
                $this->sendMailValidation($login,$mail,$clef);
                Toolbox::ajouterMessageAlerte('La commpte a ete bien creé , un mail de validation vous a ete envoyer',Toolbox::COULEUR_VERTE);
                header('Location:'.URL.'login');
            }else
            {
                Toolbox::ajouterMessageAlerte('Erreur lors de la creation du compte recommancer!',Toolbox::COULEUR_ROUGE);
                header('Location:' . URL . 'register');
            }
        }else
        {
            Toolbox::ajouterMessageAlerte('login deja existant!',Toolbox::COULEUR_ROUGE);
            header('Location:'. URL .'register');
        }
    }

        // function pour envoyer un mail de validation
        private function sendMailValidation($login,$mail,$clef){
            $urlVerification = URL."validationMail/".$login."/".$clef;
            $sujet = "Création du compte sur le site xxx";
            $message = "Pour valider votre compte veuillez cliquer sur le lien suivant ".$urlVerification;
            Toolbox::sendMail($mail,$sujet,$message);
        }

        public function renvoyerMailValidation($login)
        {
            $utilisateur = $this->UtilisateurManager->getUserinformation($login);
            $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
            header('Location:'.URL.'login');
        }

        public function validationMailComptre($login,$clef)
        {
            if($this->UtilisateurManager->bdValidationMail($login,$clef))
            {
                Toolbox::ajouterMessageAlerte('le compte a ete active',Toolbox::COULEUR_VERTE);
                header('Location:'.URL.'login');
            }else
            {
                Toolbox::ajouterMessageAlerte('le compte  n a pas ete active',Toolbox::COULEUR_ROUGE);
                header('Location:'.URL.'register');
            }
        }

        public function validation_modificationMail($mail)
        {
            if($this->UtilisateurManager->bdMofilMail($_SESSION['profil']['login'],$mail))
            {
                Toolbox::ajouterMessageAlerte('modification bien effectué',Toolbox::COULEUR_VERTE);

            }else
            {
                Toolbox::ajouterMessageAlerte('modification non effectue',Toolbox::COULEUR_ROUGE);
                
            }
            header('Location:'.URL.'compte/profil');
        }

        public function modificationPassword()
        {
            //print_r($datas); // voir si on accede au donne
           // $_SESSION['profil']['role'] = $datas['role'];
            $data_page = [
                "page_description" => "Modification mot de passe",
                "page_title" => "Titre de la page modification password ",
                "view" => "views/Utilisateur/resetpassword.views.php",
                "page_javascript" => ['modifPassword.js'],
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