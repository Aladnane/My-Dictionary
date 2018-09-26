<?php 
    require("../init.php");

    // $_SESSION = array();

    if(!isset($_SESSION['user']))
        header("location: ../index.php");
    
    $user_ID = $_SESSION['user']->user_ID;
    
    $lst_fav = get_lst_fav();

    $conditions = "user_ID = ? AND language.nom_lang = ?";

    $ar_Length = get_Length("word",$conditions, array($user_ID,'Arabic')  ,"language","word.id_lang = language.id_lang");
    $fr_Length = get_Length("word",$conditions, array($user_ID,'Frensh')  ,"language","word.id_lang = language.id_lang");
    $en_Length = get_Length("word",$conditions, array($user_ID,'English') ,"language","word.id_lang = language.id_lang");
    $sp_Length = get_Length("word",$conditions, array($user_ID,'Spanish') ,"language","word.id_lang = language.id_lang");
    $garder_Length = get_Length("sauvgarder", "user_ID = ?", array($user_ID));
    $garder_day_Length = get_Length("sauvgarder", "user_ID = ? AND date_Garder= Date(now())", array($user_ID));

    //Obtenient les langues du Traduction   (Les Titles)
    $lang_Column1 = get_Languages(1);   //Column id_trad1 FROM languages_trad
    $lang_Column2 = get_Languages(2);   //Column id_trad2 FROM languages_trad

    $lst_trad = array();

    //Fussioner les Deux Table (lang1 + lang2 = title )dans une Table 
    for($i=0; $i< count($lang_Column1); $i++)
    {
        $id_lang_trad = $lang_Column1[$i]['id_lang_trad'];
        $lang1 = $lang_Column1[$i]['nom_lang'];
        $lang2 = $lang_Column2[$i]['nom_lang'];

        $titles[$i] = "Traduction de '$lang1' Vers '$lang2'"; 
        
        //Obtenient les Traductions   (Les Mots ==> fWords + lang1)
        $trad_f = get_trad("fWord", $id_lang_trad, "DESC", 7);
        $trad_s = get_trad("sWord", $id_lang_trad, "DESC", 7);

        $lst_trad[] = new languages_trad($lang1, $lang2, $trad_f, $trad_s);  
    }

?>

<link rel='stylesheet' href="<?php echo $globaleCss; ?>" />
<link rel='stylesheet' href="css/profile.css" />
<title><?php echo $_SESSION['user']->prenom_User." ".$_SESSION['user']->nom_User?></title>


<!--Contenue-->
<section>
    <div class='container'>
        <!-- Profile Info -->
        <div class='prf_info'>
            <img class='prf_img' src='../images/user.png' />
            <h3>
                <?php echo $_SESSION['user']->prenom_User." ".$_SESSION['user']->nom_User; ?>
            </h3>
        </div>

        <!-- Languages -->
        <div class='languages groupeBox'>
            <h1 class='title'>Languages</h1>
            <!-- Language -->
            <div class='info'>
                <div>Arabic</div>    
                <span><?php echo $ar_Length;?> Words</span>    
            </div>
            <!-- Language -->
            <div class='info'>
                <div>Frensh</div>    
                <span><?php echo $fr_Length;?> Words</span>    
            </div>
            <!-- Language -->
            <div class='info'>
                <div>English</div>    
                <span><?php echo $en_Length;?> Words</span>    
            </div>
            <!-- Language -->
            <div class='info'>
                <div>Spanish</div>    
                <span><?php echo $sp_Length;?> Words</span>    
            </div>
        </div>

        <!-- Analyse -->
        <div class='analyse groupeBox'>
            <h1 class='title'>Analyse</h1>
            <!-- information -->
            <div class='info'>
                <div>Favorite</div>    
                <span><?php echo count($lst_fav);?> Words</span>    
            </div>
            <!-- information -->
            <div class='info long'>
                <div>Sauvgardés (Total)</div>    
                <span><?php echo $garder_Length;?> Words</span>    
            </div>
            <!-- information -->
            <div class='info long'>
                <div>Sauvgardés (ce Jour)</div>    
                <span><?php echo $garder_day_Length;?> Words</span>    
            </div>
            <!-- information -->
            <div class='info long'>
                <div>Challenges Succes</div>    
                <span>0 Words</span>    
            </div>
        </div>

        <!-- Les Tableaux des Mots -->
        <!-- les blocks -->
        <div class='blocks'>
            <?php
            $langs = array("Arabic"=>'ar',"Frensh"=>'fr',"English"=>'en',"Spanish"=>'sp',"Chinese"=>'ch');

            foreach($lst_trad as $trad)
            {
                if(count($trad->tradComplet) == 0) continue;

                $get_1 = $langs[$trad->lang1];
                $get_2 = $langs[$trad->lang2];

            ?>
            <!-- block 1 -->
            <div class='block'>
                <h2 class='title'>
                    <?php echo $trad->lang1."<i class=\"fas fa-arrows-alt-h to\"></i>".$trad->lang2;?>
                    <i class='fas fa-angle-down showMore'></i>

                    <?php
                    echo '<a href="all-translations.php?fLang='.$get_1.'&sLang='.$get_2.'" target="_blank">
                        <i class="fas fa-external-link-alt link" title="Afficher Tout"></i>
                    </a>';
                    ?>

                </h2>
                <div class='details'>
                    
                    <table id='tableWords' class='tableStyle1'>
                        <tr>
                            <td class='favorite'>Favorite</td>
                            <td class='firstLang'><?php echo $trad->lang1;?></td>
                            <td class='secondLang'><?php echo $trad->lang2;?></td>
                            <td class='type'>Type</td>
                            <td class='desciption'>Desciption</td>
                        </tr>

                        <!--/////////Affichage des Donnees/////////////-->
                        <?php 

                        $i=0;
                        foreach($trad->tradComplet as $tradCmp)
                        {
                            // echo "<pre>";
                            //     print_r($tradCmp);
                            // echo "<pre>";

                            $fWord = $tradCmp->fWord;
                            $sWord = $tradCmp->sWord;
                            $fav   = $tradCmp->fav ? "Fav" : "noFav";
                            $type  = $tradCmp->type;
                            $desc  = "Encore...";

                            echo 
                            "<tr>   
                                <td class='favorite'>";
                                $class =  $fav == 'Fav' ? "fas" : "far";
                            echo
                                "
                                    <i class='$class fa-star favorite'></i>
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
                            </tr>";

                            $i++;
                        }
                        ?>
                        <!--/////////Fin Affichage des Donnees/////////////-->

                    </table>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- JavaScript / JQuery-->

<script src="<?php echo $jQuery; ?>"></script>
<script src='js/profile.js'></script>
<script src='../js/globale.js'></script>
<script src='../js/globale2.js'></script>



<?php require ($footer); ?>