<?php


//Class Traduction
class traduction
{
    function __construct($trad_ID, $user_ID, $fWord,$sWord,$date_trad, $lang1,$lang2, $fav, $type, $est_Public)
    {
        $this->trad_ID    = $trad_ID;
        $this->user_ID    = $user_ID;
        $this->fWord      = $fWord;
        $this->sWord      = $sWord;
        $this->date_trad  = $date_trad;
        $this->lang1      = $lang1;
        $this->lang2      = $lang2;
        $this->fav        = $fav;
        $this->type        = $type;
        $this->est_Public = $est_Public;
    }
}


//Class Language + Traduction
class languages_trad
{
    function __construct($lang1, $lang2, $trad_f, $trad_s)
    {
        $this->lang1 = $lang1 ;
        $this->lang2 = $lang2 ;
        $this->tradComplet = $this->fussioner_trad($trad_f, $trad_s);//Tableau des Objet "Traduction"
    }

    //fussioner les Mots dans des Objet Traduction
    function fussioner_trad($trad_f, $trad_s)
    {
        global $user_ID;

        $id_User = $user_ID; 
        
        $traduction = array();
        
        for($i=0; $i<count($trad_f); $i++)
        {
            $trad_ID    = $trad_f[$i]['trad_ID'];
            $fWord      = $trad_f[$i]['fWord'];
            $sWord      = $trad_s[$i]['sWord'];
            $date_trad  = $trad_f[$i]['date_trad'];
            $est_Public = $trad_f[$i]['est_Public'];
            $type       = $trad_f[$i]['type'];
            $fav        = $this->in_Favorite($trad_ID);

            $traduction[] = new traduction($trad_ID, $user_ID, $fWord,$sWord,$date_trad, $this->lang1,$this->lang2, $fav, $type, $est_Public); 
        }    
        return $traduction;
    }

    //La traduction est en 'Favorite' ou Non
    function in_Favorite($trad_ID)     //$trad = $traduction
    {
        global $lst_fav;
        
        for($i=0; $i<count($lst_fav); $i++)
        {
            if($lst_fav[$i]['trad_ID'] == $trad_ID) 
                return true;
        }
        return false;
    }
}

//Obtenir La List du Traductions qui Sont en(Favorite)
function get_lst_fav()
{
    global $user_ID;
    
    $conditions = "traduction.user_ID = ?";
    $ON         = array("favorite.trad_ID = traduction.trad_ID");

    return readDBase("favorite.trad_ID", "favorite", $conditions, array($user_ID), array("traduction"),$ON);
}
