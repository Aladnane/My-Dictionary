<?php



    $dsn  = "mysql:host=localhost;dbname=Mydictionary";
    $user = "root";
    $pass = "";

    try
    {
        $connect = new PDO($dsn, $user, $pass);
    }
    catch(PDOException $err)
    {
        echo "Echeq de Connecter Avec La Base de Données <br />";
        echo $err->getMessage();
    }