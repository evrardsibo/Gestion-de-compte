<?php
require_once('models/MainManager.model.php');

 class utilisateurManager extends MainManager{

    private function getPasswordUser($login)
    {
        $req = "SELECT password FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR); // pour securise la requette pour eviter les injection sql
        $stmt->execute();
        $reuslt = $stmt->fetch(PDO::FETCH_ASSOC); // pour eviter de duplique les donnees
        $stmt->closeCursor();
        return $reuslt['password'];


    }

    public function isCombinaisonValide($login, $password)
    {
        $passwordBd = $this->getPasswordUser($login);
        //echo $passwordBd; pour verifier si on a acces au bd password
        return password_verify($password,$passwordBd); // pour verifier si le mot de passe donne par l'utilisateur correspond au mot de passe hashe dans la bd
    }

    public function estCompteActive($login)
    {
        $req = "SELECT est_valide FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR); // pour securise la requette pour eviter les injection sql
        $stmt->execute();
        $reuslt = $stmt->fetch(PDO::FETCH_ASSOC); // pour eviter de duplique les donnees
        $stmt->closeCursor();
        return ((int)$reuslt['est_valide'] === 1) ? true : false; // parce que les information qu"on recuper en bd sont en string il faut le mettre en entier dont (int)
    }

    public function getUserinformation($login)
    {
        $req = "SELECT * FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR); // pour securise la requette pour eviter les injection sql
        $stmt->execute();
        $reuslt = $stmt->fetch(PDO::FETCH_ASSOC); // pour eviter de duplique les donnees
        $stmt->closeCursor();
        return $reuslt;
    }

    public function bdCreercompte($login,$passwordCrypte,$mail,$clef,$image)
    {
        $req = "INSERT INTO utilisateur (login,mail,password,est_valide,clef,image,role)
                VALUES (:login,:mail,:password,0,:clef,:image,'utilisateur')";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
        $stmt->bindValue(":password",$passwordCrypte,PDO::PARAM_STR); 
        $stmt->bindValue(":clef",$clef,PDO::PARAM_INT);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;
    }

    public function VerifierloginDispo($login)
    {
        $utilisateur = $this->getUserinformation($login);
        return empty($utilisateur);

    }

    public function bdValidationMail($login,$clef)
    {
        $req = "UPDATE utilisateur SET est_valid = 1 WHERE login = :login and clef = :clef ";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":mail",$clef,PDO::PARAM_INT);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;


    }

    public function bdMofilMail($login,$mail)
    {
        $req = "UPDATE utilisateur SET mail = :mail WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;
    }

    public function modifBdPassWord($login,$newpassword)
    {
        $req = "UPDATE utilisateur SET password = :password WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":password",$newpassword,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;
    }
    public function suppBdCompte($login)
    {
        $req = "DELETE FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;
    }
    
    public function modifImageBd($login,$image)
    {
        $req = "UPDATE utilisateur SET image = :image WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier; 
    }

    public function getImageutlisateur($login)
    {
        $req = "SELECT image FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR); // pour securise la requette pour eviter les injection sql
        $stmt->execute();
        $reuslt = $stmt->fetch(PDO::FETCH_ASSOC); // pour eviter de duplique les donnees
        $stmt->closeCursor();
        return $reuslt ['image'];
    }

 } 