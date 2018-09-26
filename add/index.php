<?php 
    require("../init.php"); 

    if(!isset($_SESSION['user']))
        header("location:$home");    

    $length = 0;

    if(isset($_POST['save']))
    {

        $length = count($_POST) - 3;    //-1 for the submit button  $_POST['save'] And -2 For The Input Languages (first Lang, Second Lang)
        $length /= 5; //5 est le Nombre des propreites

        $lang1 = $_POST['lang1'];
        $lang2 = $_POST['lang2'];
        $user_ID = $_SESSION['user']->user_ID;
        
        // Verifier les Langues et Obtient Leurs id_lang 
        $id_lang1 = checke_insert_getID("id_lang", "language", "nom_lang=?", array($lang1),"nom_lang", "?", array($lang1));
        $id_lang2 = checke_insert_getID("id_lang", "language", "nom_lang=?", array($lang2),"nom_lang", "?", array($lang2));
        // ----------------------------FIN  language--------------------------------------
        
        // BOUCLE
        for($i=0; $i<$length; $i++)
        {
            $fWord = $_POST["fWord-$i"];
            $sWord = $_POST["sWord-$i"];
            $type = $_POST["type-$i"];
            $fav   = $_POST['fav-'.$i];
            $desc  = $_POST['description-'.$i];

            // Verifier les Mots et Obtient Leurs word_ID 
            $columnsADD = "word, user_ID, type, id_lang";
            //First Word
            $valuesADD  = array($fWord, $user_ID, $type, $id_lang1);
            $fWord_ID = checke_insert_getID("word_ID", "word", "user_ID=? AND word=?", array($user_ID,$fWord),$columnsADD, "?,?,?,?", $valuesADD);
            //Second Word
            $valuesADD  = array($sWord, $user_ID, $type, $id_lang2);
            $sWord_ID = checke_insert_getID("word_ID", "word", "user_ID=? AND word=?", array($user_ID,$sWord),$columnsADD, "?,?,?,?", $valuesADD);
            // ----------------------------FIN  Mot--------------------------------------
            
            // Verifier les Langues_trad et Obtient Leurs id_lang_trad
            $cls = "id_lang1,id_lang2";
            $val = array($id_lang1,$id_lang2);

            $id_lang_trad = checke_insert_getID("id_lang_trad", "languages_trad", "id_lang1=? AND id_lang2=?",
            $val, $cls, "?,?", $val); 

            // ----------------------------FIN  Langue_Trad--------------------------------------

            //Verifier la Traduction et Obtient Son trad_ID 
            $conditions = "user_ID =? AND fWord_ID = ? AND sWord_ID = ?";
            $valuesRD   = array($user_ID, $fWord_ID, $sWord_ID); 
            $columnsADD = "est_Public, date_trad, user_ID, fWord_ID, sWord_ID, id_lang_trad";
            $placeADD   = "?,now(),?,?,?,?";
            $valuesADD  = array(false, $user_ID, $fWord_ID, $sWord_ID, $id_lang_trad);

            $trad_ID = checke_insert_getID("trad_ID", "traduction", $conditions, $valuesRD, $columnsADD, $placeADD, $valuesADD);

            // ----------------------------FIN  traduction--------------------------------------
            
            //Verifier 'Favorite' /*on a besoin d'obtenir le Fav-ID*/
            if($fav == "Fav")
                checke_insert_getID("fav_ID", "favorite", "trad_ID=?", array($trad_ID), "trad_ID", "?", array($trad_ID));

            // ----------------------------FIN  Favorite--------------------------------------
        }
    }
?>

<link rel='stylesheet' href="<?php echo $globaleCss; ?>" />
<link rel='stylesheet' href="css/add.css" />


<!--  Contnue  -->

<section class='newWords'>
    <div class='container'>
        <h1 class='bigTitle'>Add New Translations</h1>
        <div class='insertWord'>
            
            <div class='chooseLang'>
                <button id='firstLang' data-lang='Frensh' class='btnStyle1'>Frensh</button>
                
                <div class='changelang'>
                    <i class="fas fa-exchange-alt"></i>
                </div>
                
                <button id='secondLang' data-lang='Arabic' class='btnStyle1'>Arabic</button>
            </div>
            
            <!-- zone of The First Word-->
            <input type='text' class='inputStyle1' name='fWord' placeholder=''/> 
            <!-- zone of The Second Word-->
            <input type='text' class='inputStyle1' name='sWord' placeholder=''/>
            
            <!--Combo Box (Select Admins/Users)-->
            <div class='comboBox'>
                <div id='typeWord' class='title'>
                    <span>Type</span>
                    <i class='fas fa-angle-down'></i>
                </div>
                <ul class='types'>
                    <li data-value='Une Mot' >Une Mot</li>
                    <li data-value='Un Verbe' >Un Verbe</li>
                    <li data-value='No Determiné' >No Determiné</li>
                </ul>
            </div>
            <!-- Fin ComboBox-->
            
            <button id='btnAdd' class='btnAdd btnStyle1'>Ajouter au Tableau</button>
        </div>
        
        <div class='wordsInserted hidden'>
            <h1 class='bigTitle'>Les Mots/Verbes Entrés</h1>
          
            <!-- Table -->
            <form action='' method='POST'>

                <!-- Les Langues -->
                <input id='inputLang1' type='hidden' name='lang1' value="Frensh" />
                <input id='inputLang2' type='hidden' name='lang2' value="Arabic" />
                
                <table id='tableWords' class='tableStyle1'>
                    <tr>
                        <td class='favorite'>Favorite</td>
                        <td class='firstLang' id='fLangColumn'><!--Langue 1--></td>
                        <td class='secondLang' id='sLangColumn'><!--Langue 2--></td>
                        <td class='type'>Type</td>
                        <td class='desciption'>Desciption</td>
                        <td class='remove'>remove</td>
                    </tr>
                <!--//////////////////////-->
                </table>

                <!--//////////////////////-->
                <input type='submit' name='save' value='Save' 
                       class='btnAdd btnStyle1'/>
            </form>

        </div>
    </div> <!--Fin Continer-->
</section>



<!-- Change The Language  (Popup)-->
<div class='popupLang'>
    <div></div>
    <div>
        <h2>Langues</h2>
        <hr>
        <div data-val='Arabic' class='lang'>Arabic</div>
        <div data-val='Frensh' class='lang'>Frensh</div>
        <div data-val='English' class='lang'>English</div>
        <div data-val='Spanish' class='lang'>Spanish</div>
        <div data-val='Chinese' class='lang'>Chinese</div>
    </div>
    
</div>
<!-- Fin Change The Language (Popup)-->





<!-- JavaScript / JQuery-->

<script src="<?php echo $jQuery; ?>"></script>
<script src='js/add.js'></script>
<script src='../js/globale.js'></script>
<script src='../js/globale2.js'></script>



<?php require($footer) ?>