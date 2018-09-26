<?php

    //Get Cookie
    
    
    $head       = "template/head.inc";
    $footer     = "template/footer.inc";
    $navBar     = "template/navBar.inc";
    $globaleCss = "css/globale.css"; 
    $fontAwsome = "css/all.min.css";
    $jQuery     = "js/jquery-3.3.1.min.js";
    $database   = "Database/connect.php";
    $DB_Functions = "Database/functions/functions.php";
    $class_User = "class/user.php";
    $class_Traduction = "class/traduction.php";
    $redirect = "redirect.php";
    $font_awesome = "css/all.min.css";
    $home = "";
    $profile = "profile";
    $picture = "images/user.png";
    $signup = "signup";
    $add = "add";

    if(!isset($isPrincipalePage))
    {
        $head       = "../" . $head  ;
        $footer     = "../" . $footer;
        $navBar     = "../" . $navBar;
        $globaleCss = "../" . $globaleCss;
        $fontAwsome = "../" . $fontAwsome;
        $jQuery     = "../" . $jQuery;
        $database    = "../" . $database;
        $DB_Functions= "../" . $DB_Functions;
        $class_User  = "../" . $class_User;
        $class_Traduction  = "../" . $class_Traduction;
        $redirect  = "../" . $redirect;
        $font_awesome  = "../" . $font_awesome;
        $home  = "../";
        $profile  = "../" . $profile;
        $picture  = "../" . $picture;
        $signup  = "../" . $signup;
        $add  = "../" . $add;
    }

    require($database);
    require($DB_Functions);
    require($class_User);
    require($class_Traduction);

    session_start();

    require($head);
    require($navBar);

    