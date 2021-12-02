<?php
require_once('models/MainManager.model.php');
 class VisiteurManager extends MainManager{

    public function getUtilisateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC); // pour ne pas avoir des doublons
        $req->closeCursor();
        return $datas;
    }

 } 