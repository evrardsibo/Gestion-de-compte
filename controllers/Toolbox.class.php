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
}