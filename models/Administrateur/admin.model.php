<?php
require_once('./models/Model.class.php');
require_once('./models/MainManager.model.php');

class adminManager extends MainManager
{
    public function getUtilisateurs()
    {
        $req = "SELECT * FROM utilisateur";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;

    }

    public function validationBdRole($login,$role)
    {
        $req = "UPDATE utilisateur SET role = :role WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req); //aller chercher la connection a la bdd
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":role",$role,PDO::PARAM_STR);
        $stmt->execute(); 
        $estModifier = ($stmt->rowcount() > 0); // verifier le nombre de ligne ajoiter en bd voir aussi si le arequette a bien fonctionne
        $stmt->closeCursor();
        return $estModifier;
    }
}