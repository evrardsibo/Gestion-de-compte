<?php
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
"://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"])); // constant URL pour que tout le fichier ponter sur la racine

require_once("./controllers/Visiteur/visiteur.controller.php");
require_once("controllers/Utilisateur/utilisateur.controller.php");
require_once('controllers/Toolbox.class.php');
require_once('controllers/securite.class.php');
$visiteurController = new VisiteurController(); // controller pour pilote tout le pages du site
$utlisateurController = new UlitisateurController();
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
        case "register" : $visiteurController->register();
        break;
        case "validation_login" : 
            if(!empty($_POST['login']) && !empty($_POST['password']))
            {
                $login = Securite::secureHTML($_POST['login']);
                $password = Securite::secureHTML($_POST['password']);
                $utlisateurController->validation_login($login, $password);
            }else
            {
                Toolbox::ajouterMessageAlerte('Login ou mot de passe non reseigne',Toolbox::COULEUR_ROUGE);
                header('Location:' . URL . 'login'); // lerouter en php on utliser header
            }
        break;
        case "validation_creerCompte" : 
            if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail']))
            {
                $login = Securite::secureHTML($_POST['login']);
                $password = Securite::secureHTML($_POST['password']);
                $mail = Securite::secureHTML($_POST['mail']);
                $utlisateurController->validation_creerCompte($login,$password,$mail);

            }else
            {
                Toolbox::ajouterMessageAlerte('Veuillez remplir tous champs !',Toolbox::COULEUR_ROUGE);
                header('Location:' . URL . 'register');
            };
            
        break;
        case "renvoyerMailValidation" : $utlisateurController->renvoyerMailValidation($url[1]);
        break;
        case "validationMail" : $utlisateurController->validationMailComptre($url[1],$url[2]);
        break;
        case "compte" : 
            if(!Securite::estConnect())
            {
                Toolbox::ajouterMessageAlerte('Veuillez vous connecter !',Toolbox::COULEUR_ROUGE);
                header('location:'.URL.'login');

            }else
            {

                switch($url[1]){
                    case "profil": $utlisateurController->profil();
                    break;
                    case "deconecte": $utlisateurController->deconnexion();
                    break;
                    case "validation_modification": $utlisateurController->validation_modificationMail(Securite::secureHTML($_POST['mail']));
                    break;
                    case "modifPassword": $utlisateurController->modificationPassword();
                    break;
                    case "suppcompte": $utlisateurController->suppressionCompte();
                    break;
                    case "validation_Password":
                        if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword'])  && !empty($_POST['confirmpassword'])){
                                $oldpassword = Securite::secureHTML($_POST['oldpassword']);
                                $newpassword = Securite::secureHTML($_POST['newpassword']);
                                $confirmpassword = Securite::secureHTML($_POST['confirmpassword']);
                                $utlisateurController->validation_Password($oldpassword, $newpassword, $confirmpassword);
                            
                        }else{
                            Toolbox::ajouterMessageAlerte('veillez resegnie tous les champs',Toolbox::COULEUR_ROUGE);
                            header('Location:'.URL.'compte/modifPassword');
                        };
                    break;
                    // print_r($_FILES['image']) pour voir l information qui a ete recuperer dans le file
                    case 'modificationPhoto' :
                        if($_FILES['image']['size'] > 0)
                        {
                            $utlisateurController->modifPhoto($_FILES['image']);
                        }else
                        {
                            Toolbox::ajouterMessageAlerte('veuillez ajoute une image',Toolbox::COULEUR_ROUGE);
                            header('Location:'.URL.'compte/profil');
                        } ;
                    break;
                    default : throw new Exception("La page n'existe pas");
                }
            }
        break;

        default : throw new Exception("La page n'existe pas"); //expection traite erreur
    }
} catch (Exception $e){
    $visiteurController->pageErreur($e->getMessage()); //page pour gerer les erreurs
}