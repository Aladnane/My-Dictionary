<?php 
    require("../init.php");

    if(!isset($_SESSION['user']))
        header("location: ../index.php");

    $user_ID = $_SESSION['user']->user_ID;

    
    if(!isset($_GET['fLang']) || !isset($_GET['sLang']))
        header("location: index.php");
    
    //les Traductions Qui Sont ( Sauvgardés )
    $garder = get_sauvgarder();


    //Enregistrer Le 'POST'     (Mise à Jour de Les Donnees)
    if(isset($_POST['save']))
    {
        $trads_IDS = $_SESSION["traductions_ID"];
        
        $length = count($_SESSION["traductions_ID"]);
    

        for($i=0; $i<$length; $i++)
        {
            //Supprimer
            if($_POST["remove-$i"] == "remove")
            {
                //Remove From DataBase
                $word_IDS = readDBase("fWord_ID,sWord_ID","traduction", "trad_ID=?",array($trads_IDS[$i]),array(),array());
                $word_IDS = $word_IDS[0];
                
                $fWord_ID = $word_IDS['fWord_ID'];
                $sWord_ID = $word_IDS['sWord_ID'];

                //Delete The Words of The traduction
                delete_DBase("word", "word_ID = ? OR word_ID = ?", array($fWord_ID, $sWord_ID));

                //Ramarque:Important: Delete Word ==> Delete Traduction !!!

                //Get Index And Remove the Trad From array => '$garder'
                $indexTrad_ID = array_search($trads_IDS[$i], $garder);
                unset($garder[$indexTrad_ID]);
                continue;
            }
            //Fin Supprission 
            
            //Favorite
            if($_POST["fav-$i"] == "Fav")   //Ajouter la traduction dans le Tableau des 'Favorite'
            {
                //Verifier l'existance de La Traduction Avant de l'inserer
                $count = get_Length("favorite", "trad_ID = ?", array($trads_IDS[$i]));
    
                if($count == 0)  //inserer La Traduction
                {
                    insertInDB("favorite", "trad_ID", "?", array($trads_IDS[$i]));    
                }
            }
            elseif($_POST["fav-$i"] == "noFav-changed") //Supprimer la traduction dans le Tableau des 'Favorite'
            {
                delete_DBase('Favorite', "trad_ID = ?", array($trads_IDS[$i]));
            }
            //Fin Favorite
            
            //Save In 'sauvgarder' Table 
            if(($_POST["garder-$i"] == "garder") && (!in_array($trads_IDS[$i],$garder))) 
            {
                $trad_ID = $_SESSION["traductions_ID"][$i];
                $garder[] = $trads_IDS[$i];

                insertInDB("sauvgarder", "user_ID, trad_ID, date_Garder", "?,?,now()", array($user_ID,$trad_ID));
            }
            //Delete FROM 'Sauvgarder'
            elseif(($_POST["garder-$i"] == "") && (in_array($trads_IDS[$i],$garder))) 
            {
                delete_DBase("sauvgarder", "trad_ID = ?", array($trads_IDS[$i]));

                //Get Index And Remove the Trad From array => '$garder'
                $indexTrad_ID = array_search($trads_IDS[$i], $garder);
                unset($garder[$indexTrad_ID]);
            }
        }
    }

    
    //Requeperer Les 'Traductions'
    
    $lst_fav = get_lst_fav();   //Lire Le tableau "Favorite";
        
    $langs = array("ar"=>'Arabic',"fr"=>'Frensh',"en"=>'English',"sp"=>'Spanish',"ch"=>'Chinese');
    
    $fLang = $_GET['fLang'];
    $sLang = $_GET['sLang'];

    if($fLang == $sLang || !array_key_exists($fLang, $langs) || !array_key_exists($sLang, $langs))
        header("location: index.php");
    
    $lang1 = $langs[ $_GET['fLang'] ] ;
    $lang2 = $langs[ $_GET['sLang'] ] ;


    //Get id_lang
    $id_lang1 = readDBase("id_lang", "language", "nom_lang = ?", array($lang1))[0]['id_lang'];
    $id_lang2 = readDBase("id_lang", "language", "nom_lang = ?", array($lang2))[0]['id_lang'];

    //id_lang_trad
    $id_lang_trad = readDBase("id_lang_trad", "languages_trad", "id_lang1=? AND id_lang2=?", array($id_lang1,$id_lang2))[0]['id_lang_trad'];

    $trad_f = get_trad("fWord", $id_lang_trad); //  1/2 traduction les Premier Mots
    $trad_s = get_trad("sWord", $id_lang_trad); //  1/2 traduction les Deuxiemme Mots

    $lst_trad[] = new languages_trad($lang1, $lang2, $trad_f, $trad_s);        

    $tradComplet = $lst_trad[0]->tradComplet; // 0 car il ya une Seul type de Traduction (fr->sp) || (sp->ar) || ...
?>

<link rel='stylesheet' href="<?php echo $globaleCss; ?>" />
<link rel='stylesheet' href="css/profile.css" />
<link rel='stylesheet' href="css/all-translations.css" />
<title><?php echo $lang1." - ".$lang2; ?></title>

 <!-- Contenue -->
<section class='tblGest container'>
    <label class='bigTitle'><?php echo $lang1." <i class=\"fas fa-arrows-alt-h\"></i> ".$lang2; ?></label>
    
    <!-- Table -->
    <form action='' method='POST'>
    <table id='tableWords' class='tableStyle1' data-length="<?php echo count($tradComplet);?>">
        <tr>
            <td class='favorite'>Sauvgardé</td>
            <td class='favorite'>Favorite</td>
            <td class='firstLang' id='lang1'><?php echo $lang1;?></td>
            <td class='secondLang' id='lang2'><?php echo $lang2;?></td>
            <td class='type'>Type</td>
            <td class='desciption'>Desciption</td>
            <td class='remove'>remove</td>
        </tr>

        <!--/////////Affichage des Donnees/////////////-->
        <?php 

        //Sauvgarder les trad_ID des Traduction Pour Les Modifiés
        $_SESSION["traductions_ID"] = array();  

        $i=0;
        foreach($tradComplet as $tradCmp)
        {
            $trad_ID = $tradCmp->trad_ID;
            $fWord = $tradCmp->fWord;
            $sWord = $tradCmp->sWord;
            $fav   = $tradCmp->fav ? "Fav" : "noFav";
            $type  = $tradCmp->type;
            $desc  = "Encore...";

            $class_fav =  $fav == 'Fav' ? "fas" : "far";
            $class_trad =  in_array($trad_ID, $garder) ? "fas" : "far";
            $value_trad =  in_array($trad_ID, $garder) ? "garder" : '';

            $_SESSION["traductions_ID"][] = $trad_ID;
            echo 
            "<tr data-index=$i>   
                <td class='garder icon'>
                    <i class='$class_trad fa-save save'></i>
                    <input type='hidden' name='garder-$i' value='$value_trad' />
                </td>

                <td class='favorite icon'>
                    <i class='$class_fav fa-star favorite'></i>
                    <input type='hidden' name='fav-$i' value='$fav'>
                </td>
        
                <td class='firstLang'>
                    $fWord
                    <input type='hidden' name='fWord-$i' value='$fWord'>
                </td>
        
                <td class='secondLang'>
                    $sWord
                    <input type='hidden' name='sWord-$i' value='$sWord'>
                </td>
        
                <td class='type'>
                    $type
                <input type='hidden' name='type-$i' value='$type'>
                </td>
        
                <td class='desciption'>
                    $desc
                    <input type='hidden' name='description-$i' value='This is the Description'/>
                </td>

                <td class='remove  icon'>
                    <i class=\"fas fa-trash-alt remove\"></i>
                    <input type='hidden' name='remove-$i' value=''/>
                </td>
            </tr>";

            $i++;
        }
        ?>
        <!--/////////Fin Affichage des Donnees/////////////-->

    </table>
        <div class='options'>
            <input type='submit' name='save' value='Save' class='btnStyle1'/>
            <button class='btnStyle1 cancel'> Cancel </button>
        </div>
    </form>
    
</section>

<!-- Afficher Une Traduction  -->
<!-- Change The Language  (Popup)-->
<div class='popupTrad'>
    <div class='background'></div>
    <div>
        <i class="far fa-times-circle close"></i>
        <div class='titre'>
            <h2>FistLang</h2>
            <i class="fas fa-exchange-alt"></i>
            <h2> SecondLang</h2>
        </div>

        <div class='words'>
            <i class="left"></i>           
            <h2>fWord</h2>
            <i class="fas fa-arrows-alt-h"></i>
            <h2>sWord</h2>
            
            <i class="right"></i>
        </div>

        <div class='options'>
            <i class="save"></i>
            <i class="favorite"></i>

            <i class="fas fa-trash-alt remove"></i>
        </div>
    </div>
    
</div>
<!-- Fin Change The Language (Popup)-->


<!-- JavaScript / JQuery-->

<script src="<?php echo $jQuery; ?>"></script>
<script src='../js/globale2.js'></script>
<script src='../js/globale.js'></script>
<script src='js/profile.js'></script>
<script src='js/All-translations.js'></script>


<?php require ($footer); ?>