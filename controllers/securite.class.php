<?php
 class Securite
 {
     // pour plus de securite evite qu'u hacker puisse vole l'identite dans la session de l'utilisateur
     public const COOkIE_NAME = 'karabaye';

    public static function secureHTML($sec)
    {
        return htmlentities($sec);
    }

    public static function estConnect()
    {
        return (!empty($_SESSION['profil']));
        // pour verifeir si l'utilisateur est connecte ou pas
    }

    public static function isUser()
    {
        return($_SESSION['profil']['role'] === 'utilisateur');
    }

    public static function isAdmin()
    {
        return($_SESSION['profil']['role'] === 'admin');
    }

    // function permettant de gener le cookie au moment de validation de connexion

    public static function genereCookieConnexion()
    {
        $ticket = session_id().microtime().rand(0,9999999);
        $ticket = hash('sha512',$ticket);
        setcookie(self::COOkIE_NAME,$ticket,time()+(60*30));
        $_SESSION['profil'][self::COOkIE_NAME] = $ticket;
    }

    // function pour le controle si le cookie corespond a ce qui se trouve dans la variable de session

    public static function checkCookieConnexion()
    {
        return $_COOKIE[self::COOkIE_NAME] === $_SESSION['profil'][self::COOkIE_NAME];
    }
 }