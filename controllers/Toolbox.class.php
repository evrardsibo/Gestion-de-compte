<?php
class Toolbox {
    public const COULEUR_ROUGE = "alert-danger";
    public const COULEUR_ORANGE = "alert-warning";
    public const COULEUR_VERTE = "alert-success";
    // pour gerer les alertes

    public static function ajouterMessageAlerte($message,$type){
        $_SESSION['alert'][]=[
            "message" => $message,
            "type" => $type
        ];
    }

     // fnction static pour envoyer un mail da validation avec la function mail() de php
     public static function sendMail($destinataire, $sujet, $message){
        $headers = "From: evrard.sibomana@gmail.com";
        if(mail($destinataire,$sujet,$message,$headers)){
            self::ajouterMessageAlerte("Mail envoyé", self::COULEUR_VERTE);
        } else {
            self::ajouterMessageAlerte("Mail non envoyé", self::COULEUR_ROUGE);
        }
    }

    // function static pour la verification de l'image avant de l'envoyer dans la bdCreercompte
    // cette finction recuper aussi le fichier et le repertoire
    public static function ajoutImage($file, $dir){
        // teste le nom de l'image
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");
     // cette condition pour voir si le dossier existe si non le creer
        if(!file_exists($dir)) mkdir($dir,0777);
     // pour trouver l'extension de l'image et generer aussi un nom de l'image
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];
        
        // verification de l'extension de l'image et la taille 

        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
          // ajouter dans le dossier correspond l'image  
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
            //retourne le nom de l'image qu'on va placer dans le bd
        else return ($random."_".$file['name']);
    }
}