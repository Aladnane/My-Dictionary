<?php


    //Cookies get The User Account
    if(!isset($_SESSION['user']) && isset($_COOKIE['user_ID']) && isset($_COOKIE['cookie_ID']))
    {
        //check
        $id_cookie = $_COOKIE['cookie_ID'];
        $user_ID = $_COOKIE['user_ID'];

        $count = get_Length("browser_cookies", "id_cookie=? AND user_ID=?", array($id_cookie,$user_ID));
        if($count > 0)
        {
            $columns = "browser_cookies.user_ID, user.nom_User, user.prenom_User, user.email, user.username"; //Tous Les Colonnes Sauf "Password"
            $ON = array("browser_cookies.user_ID = user.user_ID");
            $conditions = "browser_cookies.user_ID = ?";
            $values = array($user_ID);

            $data = readDBase($columns, "browser_cookies", $conditions, $values,array("user"),$ON);

            $user_ID     = $data[0]['user_ID'];
            $nom_User    = $data[0]['nom_User'];
            $prenom_User = $data[0]['prenom_User'];
            $email       = $data[0]['email'];
            $username    = $data[0]['username'];

            create_save_user($user_ID, $nom_User, $prenom_User, $email, $username);
        }
    }

    //Logout
    if((isset($_GET['action']))&&($_GET['action'] == 'logout')&&(isset($_SESSION['user'])))
    {
        $_SESSION = array();
        setcookie("user_ID",'',time()- 3600, "/");
        setcookie("cookie_ID",'',time()- 3600, "/");
    }

    
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset='utf-8' />
     <link rel='stylesheet' href="<?php echo $font_awesome;?>" />
</head>

<body>