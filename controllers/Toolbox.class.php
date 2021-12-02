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
}