<?php

    require("Database/connect.php");
    require("Database/functions/functions.php");
    require("class/user.php");

    session_start();

    //Si le Passage n'est Avec La Method "POST" => redirect to home 
    if(!($_SERVER["REQUEST_METHOD"] == "POST"))
        header("location: index.php");

    $signup_Lien = "http://localhost/php/dictionnaire/signup/";
    $last_Lien   = $_SERVER["HTTP_REFERER"];

    //Login
    if(($_GET['type'] == 'login') && (isset($_POST['login'])))
    {
        $columns = "user_ID, nom_User, prenom_User, email, username"; //Tous Les Colonnes Sauf "Password"
        $conditions = "username = ? AND password = ?";
        $values = array($_POST['username'], $_POST['password']);

        $data = readDBase($columns, "user", $conditions, $values);

        if(count($data) == 0)
            die("Votre \"Username\" Ou \"Password\" est Incorrect !");
        
        $user_ID     = $data[0]['user_ID'];
        $nom_User    = $data[0]['nom_User'];
        $prenom_User = $data[0]['prenom_User'];
        $email       = $data[0]['email'];
        $username    = $data[0]['username'];
        
        create_save_user($user_ID, $nom_User, $prenom_User, $email, $username);
    }
    //SignUp
    elseif(($_GET['type'] == 'sign') && (isset($_POST['signup'])) && ($last_Lien == $signup_Lien))
    {
        $nom_User    = $_POST['lastname'];
        $prenom_User = $_POST['firstname'] ;
        $email       = $_POST['email']    ;
        $username    = $_POST['username'] ;
        $password    = $_POST['password'] ;

        //Check After INSERT
        $data = readDBase("user_ID", "user", "username = ? OR email = ?", array($username, $email));

        if(count($data) != 0) die("Erreur Votre 'Username' ou 'email' est deja Existe !!!!!!!!!!!!!!!!!");
        
        $columns = "nom_User, prenom_User, email, password, username";
        $table = "user";
        $places = "?,?,?,?,?";
        $value = array( $nom_User, $prenom_User, $email, $password, $username );
    
        insertInDB($table, $columns, $places, $value);
        
        //This ID is From DB
        $user_ID = get_user_ID($_POST['username']);

        create_save_user($user_ID, $nom_User, $prenom_User, $email, $username);
    }
    
    header("location: index.php");