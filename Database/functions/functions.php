<?php


    //Insert The Data Into The DataBase
    function insertInDB($table, $columns, $places, $value)
    {
        global $connect;
        
        $line = "INSERT INTO $table ( $columns )VALUES($places)";
        
        $stmt = $connect->prepare($line);

        $stmt->execute($value);
    }

    // Read From The DataBase
    function readDBase($columns, $table, $conditions = null, $values = array(), $join=array(),$ON=array(),$orderBy = '', $limit = 0)
    {
        global $connect;

        $line = "SELECT $columns FROM $table ";

        if(count($join) != 0)
        {
            for($i=0; $i<count($join); $i++)
                $line .= " JOIN ".$join[$i]." ON ".$ON[$i];
        }

        if($conditions != null) $line .= " WHERE $conditions";

        if(!empty($orderBy)) $line .= " ORDER BY $orderBy";

        if($limit >0) $line .= " LIMIT $limit";
        
        $stmt = $connect->prepare($line);
        $stmt->execute($values);

        return $stmt->fetchAll();
    }

    //DELETE From The DataBase
    function delete_DBase($table, $conditions = '', $values = array())
    {
        global $connect;

        $line = "DELETE FROM $table";
        if(!empty($conditions))
            $line .= " WHERE $conditions ";
        
        $stmt = $connect->prepare($line);
        $stmt->execute($values);
    }



    //Get Length
    function get_Length($table, $conditions = NULL, $values = array(),$join = NULL ,$on = NULL)
    {
        global $connect;

        $line = "SELECT COUNT(*) FROM $table ";

        if($join != NULL)
        {
            $line .= " JOIN $join ";
            $line .= " ON $on";
        }

        if($conditions != NULL)
        {
            $line .= " WHERE $conditions";
        }

        $stmt = $connect->prepare($line);
        $stmt->execute($values);
        
        return $stmt->fetchColumn();
    }
        
    //Get The ID v1
    function get_user_ID($username)
    {
        $myArray = readDBase("user_ID", "user", "username = ?", array($username));
        return $myArray[0]['user_ID']; //il exist uniquement un et un seul 'ID' qui Correspond à de 'username' là
    }

    // Checke And Get ID
    function checke_insert_getID($columnsRead, $table, $conditions, $valuesRD, $columnsADD, $placeADD, $valuesADD)
    {
        $data = readDBase($columnsRead, $table,  $conditions , $valuesRD);
        if(count($data) == 0)
        {
            insertInDB($table, $columnsADD , $placeADD, $valuesADD);
            $data = readDBase($columnsRead, $table,  $conditions , $valuesRD);
        }
        return $data[0][$columnsRead];
    }
        
    
    //Obtenient les Traductions   Les Mots ==>(fWords + lang1) ET (sWords + lang2) 
    function get_trad($word, $id_lang_trad, $by = 'ASC', $limit = 0)
    {
        global $user_ID;

        $columns = "trad_ID, word.word as $word,date_trad, word.type ,est_Public";
        $conditions = "traduction.user_ID = ? AND traduction.id_lang_trad = ?";
        $values = array($user_ID, $id_lang_trad);
        $join = array("word");
        $ON   = array("traduction.".$word."_ID = word.word_ID");
        $orderBy = "traduction.trad_ID $by";
        
        return readDBase($columns, "traduction", $conditions,$values, $join,$ON,$orderBy,$limit);        
    }
        
    //Obtenient les langues du Traduction   (Les Titles)
    function get_Languages($NbrColumn)
    {
        global $user_ID;
        
        $columns = "languages_trad.id_lang_trad, language.nom_lang";
        $join = array("language"/*, "traduction"*/); 
        $on = array(
                    "language.id_lang = languages_trad.id_lang$NbrColumn" 
                    // "languages_trad.id_lang_trad = traduction.id_lang_trad"
                    );
        $conditions = array();//"traduction.user_ID = ?";
        $orderBy = "languages_trad.id_lang_trad ASC";

        return readDBase($columns, "languages_trad", $conditions, array(), $join,$on,$orderBy);
    }
        
        
    //les Traductions Qui Sont ( Sauvgardés )
    function get_sauvgarder()
    {    
        global $user_ID;

        $trad_garder = readDBase("trad_ID, date_Garder", "sauvgarder", "user_ID = ?", array($user_ID));

        $garder = array();
        foreach($trad_garder as $trad)
        {
            $garder[] = $trad["trad_ID"]; 
        }
        return $garder;
    }

    //Create object User in Save it in Session And Cookie
    function create_save_user($user_ID, $nom_User, $prenom_User, $email, $username)
    {
        // Create The Object
        $user = new user($user_ID, $nom_User, $prenom_User, $email, $username);        

        //Sauvgarder l'objet dans le SESSION
        $_SESSION['user'] = $user;

        if(!isset($_COOKIE['user_ID']) || !isset($_COOKIE['cookie_ID']))
        {
            //Set Cookie
            //check if the user have a cookie_ID ==> so is Exists in "browser_cookies" Table  
            $last_cookieID = readDBase("id_cookie", "browser_cookies", "user_ID=?",array($user_ID));
            if(count($last_cookieID) == 0)
            {
                $cookie_ID = rand();
                //Save The Cookies In The DB   
                insertInDB("browser_cookies", "id_cookie,user_ID", "?,?", array($cookie_ID,$user_ID));
            }
            else    //Si Le Cookie Deja Existe Dans La Table "browser_cookies"
                $cookie_ID = $last_cookieID[0]['id_cookie'];

            setcookie("user_ID",$user_ID,time()+(3600 * 24 * 365), "/");
            setcookie("cookie_ID", $cookie_ID, time()+ (3600 * 24 * 365), "/");
        }
    }