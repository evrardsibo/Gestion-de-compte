<?php
 class Securite
 {
    public static function secureHTML($sec)
    {
        return htmlentities($sec);
    }

    public static function estConnect()
    {
        return (!empty($_SESSION['profil']));
        // pour verifeir si l'utilisateur est connecte ou pas
    }
 }