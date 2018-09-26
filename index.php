<?php 
    $isPrincipalePage = '';
    require("init.php");
?>

<title>My Dictionary</title>
<link rel='stylesheet' href="<?php echo $globaleCss; ?>" />
<link rel='stylesheet' href='css/home.css' />

<header>

    <img src='images/background1.jpg' />
    <!-- <div class='background'></div> -->
    <!-- Contenue -->
    <div class='container'>
        <h1><span>M</span>y <span>D</span>ictionary</h1>
        <p><span>C</span>e Site vous aide de Sauvgarder Les Mots et Les Verbes et de Gerer Votre Bibliothéque des Mots
            Dans n'importe Quelle Endroit
            Et de Consevoir Votre Niveau Dans Les Langues
        </p>

        <!-- <div class='icons'>
            <img src='images/arabic-icon.png' />
            <img src='images/english-icon.png' />
        </div> -->

    </div>
</header>

<!-- Login -->
<section class='login'>
    <h1 class='title'>Inscrire</h1>
    <img src='images/user3.png' />

    <ul class='avantage'>
        <li>
            <i class="fas fa-angle-double-right"></i>
            Sauvgarder Vos Traductions jusqu'a l'infini
        </li>
        <li>
            <i class="fas fa-angle-double-right"></i>
            Faire Des Consultation de Votre Niveau
        </li>
        <li>
            <i class="fas fa-angle-double-right"></i>
            Connetre Les Nouvelles Mots Que Vous Avez Etudié
        </li>
        <li>
            <i class="fas fa-angle-double-right"></i>
            Faire des 'Challenges' Avec Vos Amis
        </li>
    </ul>

    <?php
        if(!isset($_SESSION['user']))
            echo "<a href='signup/'><button class='btnStyle2'>Inscrire</button></a>";
    ?>
    
</section>

<!-- New Words -->
<section class='newWords'>
    <img src='images/languages.jpg' />
    <h1 class='bigTitle'>Le SiteWeb Supporte Tout Les Langage</h1>

</section>

<!-- More info -->
<div class='siteInfo'>
    <h1 class='bigTitle'>catalogue du Site 'MyDictionary'</h1>
    <div class='moreInfo container'>

        <!-- Block -->
        <div class='block'>
            <h2>A propos de 'myDictionary'</h2>
            <p>
                Ce Site Vous Donne La Possibilité de Gerer Votre Traductions
                ,Grace à ç'interface Qui Presente Tout Les Informations de Votre
                niveau Dans Les Langages Précisés 
            </p>
        </div>

        <!-- Block -->
        <div class='block'>
            <h2>myDictionary</h2>
            <ul>
                <li><a href='#'>Link 1</a></li>
                <li><a href='#'>Link 2</a></li>
                <li><a href='#'>Link 3</a></li>
                <li><a href='#'>Link 4</a></li>
                <li><a href='#'>Link 5</a></li>
            </ul>
        </div>
        <!-- Block -->
        <div class='block'>
            <h2>de Plus</h2>
            <ul>
                <li><a href='#'>Link 6</a></li>
                <li><a href='#'>Link 7</a></li>
                <li><a href='#'>Link 8</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>

    <div class='container'>
            Ce Site Est Crée par <span>Younes Adnane</span> &copy; 2018
            <div class='version'>
                <span>MyDictionary</span> Version 1
            </div>
    </div>

    
</footer>



<!-- JavaScript / jQuery-->
<script src='js/jquery-3.3.1.min.js'></script>
<script src='js/globale.js'></script>
<script src='js/globale2.js'></script>
<script src='js/home.js'></script>

<?php require ($footer); ?>