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
            if($this->UtilisateurManager->bdCreercompte($login,$passwordCrypte,$mail,$clef,'profils/profil.jpg'))
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

        public function validation_Password($oldpassword, $newpassword, $confirmpassword)
        {
            if($newpassword === $confirmpassword)
            {
                // function iscombinaison pour voir si le passeword existe dans la bd surtout da la session
                if($this->UtilisateurManager->isCombinaisonValide($_SESSION['profil']['login'],$oldpassword))
                {
                    $passwordCrypte = password_hash($newpassword,PASSWORD_DEFAULT);
                    if($this->UtilisateurManager->modifBdPassWord($_SESSION['profil']['login'], $passwordCrypte))
                    {
                        Toolbox::ajouterMessageAlerte('mot de passe modifier',Toolbox::COULEUR_VERTE);
                        header('Location:'.URL. 'login'); 
                    }else
                    {
                        Toolbox::ajouterMessageAlerte('erreur de modification',Toolbox::COULEUR_ROUGE);
                        header('Location:'.URL. 'compte/modifPassword'); 
                    }

                }else
                {
                    Toolbox::ajouterMessageAlerte('ancien mot de passe incorrecte',Toolbox::COULEUR_ROUGE);
                    header('Location:'.URL. 'compte/modifPassword'); 
                }
            }else
            {
                Toolbox::ajouterMessageAlerte('mot de passe ne sont indentique',Toolbox::COULEUR_ROUGE);
                header('Location:'.URL. 'compte/modifPassword');
            }
        }
        public function suppressionCompte()
        {
            // ca va supprime en meme temps le profil et l'image
            $this->dossierSupprime($_SESSION['profil']['login']);
            // pour supprime le dossier aussi

            rmdir('public/Assets/images/profils/'.$_SESSION['profil']['login']);
            if($this->UtilisateurManager->suppBdCompte($_SESSION['profil']['login']))
            {
                Toolbox::ajouterMessageAlerte('compte bien supprime',Toolbox::COULEUR_VERTE);
                $this->deconnexion();
            }else
            {
                Toolbox::ajouterMessageAlerte('compte non supprime',Toolbox::COULEUR_ROUGE);
                header('Location:'.URL.'compte/profil');
            }
        }

        public function modifPhoto($file)
        {
            try
            {
                // pour creer une repertoire de profil pour chaque utilisateur et / pour indique que c'est un repertoire
               $repertoire = "public/Assets/images/profils/".$_SESSION['profil']['login'].'/';
               $recupimage = Toolbox::ajoutImage($file,$repertoire);
               // pour enregistre dans la bd le chemin complet 
               $recupimagebd = "profils/".$_SESSION['profil']['login'].'/' . $recupimage ;
               // pour que quand on supprime le profil le dossier soit supprime aussi
               $this->dossierSupprime($_SESSION['profil']['login']);
               if($this->UtilisateurManager->modifImageBd($_SESSION['profil']['login'],$recupimagebd))
               {
                    Toolbox::ajouterMessageAlerte('profil bien modifie',Toolbox::COULEUR_VERTE);
                    
               }else
               {
                   Toolbox::ajouterMessageAlerte('profil non modifie',Toolbox::COULEUR_ROUGE);
                   
               }
            }catch(Exception $e)
            {
                Toolbox::ajouterMessageAlerte($e->getMessage(),Toolbox::COULEUR_ROUGE);
            }
           header('Location:'.URL.'compte/profil');
            

        }

        private function dossierSupprime($login)
        {
                 // variable pour recuper l'ancien image de profil et le supprime
                 $oldimage = $this->UtilisateurManager->getImageutlisateur($_SESSION['profil']['login']);
                 //condition pour supprime l'ancien profil dans la repertoire et mettre le nouveau
 
             if($oldimage !== 'profils/profil.jpg')
             {
                 // function pour supprimer l'image dans le dossier voir chemin
 
                 unlink('public/Assets/images/' . $oldimage );
             }
        }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
        // faire appel la function de la class parent
    }
    
}