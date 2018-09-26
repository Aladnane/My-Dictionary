<?php

class user
{
    function __construct($user_ID, $nom_User, $prenom_User, $email, $username)
    {
        $this->user_ID     = $user_ID;
        $this->nom_User    = $nom_User;
        $this->prenom_User = $prenom_User;
        $this->email       = $email;
        $this->username    = $username;
    }
    
    
    
}