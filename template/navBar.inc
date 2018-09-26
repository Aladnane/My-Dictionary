<?php

    $news         = "#";
    $testimonials = "#";
    $contact      = "#";
    $webdeveloper = "#";
    $editInfo     = "#";
    $logOut       = "#";
        
    $class = isset($isPrincipalePage) ? 'home' : '';
?>

<nav class='navGlb <?php echo $class?>'>
    <div class='container'>
        <ul>
            <li class='li_a'><a href="<?php echo $home;?>">Home</a></li>
            <?php 
            if(isset($_SESSION['user']))
            {
            ?>
            <li>
                Profile <i class='fas fa-angle-down'></i>
                <ul class='sousMenu'>
                    <li><a href="<?php echo $profile;?>">Consulter</a></li>
                    <li>Choix 2</li>
                    <li>Choix 3</li>
                </ul>
            </li>
            <!--Words-->
            <li>
                Traduction <i class='fas fa-angle-down'></i>
                <ul class='sousMenu'>
                    <li><a href="<?php echo $add;?>">Ajouter Traduction</a></li>
                    <li>Choix 2</li>
                    <li>Choix 3</li>
                </ul>
            </li>
            
            <?php }?>
            
            <li>
                Tab 2 <i class='fas fa-angle-down'></i>
                <ul class='sousMenu'>
                    <li>Choix 1</li>
                    <li>Choix 2</li>
                    <li>Choix 3</li>
                </ul>
            </li>
            
            <li>
                Tab 3 <i class='fas fa-angle-down'></i>
                <ul class='sousMenu'>
                    <li>Choix 1</li>
                    <li>Choix 2</li>
                    <li>Choix 3</li>
                </ul>
            </li>

        
            <!--Login-->

            <?php
            if(!isset($_SESSION['user']))
            {
                ?>
                <li class='li_login'>
                    <i class='fas fa-angle-down'></i> Login
                    <ul class='sousMenu sMenuLogin'>
                        <form action="<?php echo $redirect."?type=login"; ?>"  class='formGlb' method='POST'>
                            <h3>Login</h3>
                            <input type='text' name='username' placeholder='Username' />
                            <div>
                                <input type='password' name='password' class='password' placeholder='Password'/>
                            </div>
                            <input type='submit' name='login' value='login' title='login'/>
                        </form>
                    </ul>
                </li>
            <?php
            }
                ?>
        </ul>
        <?php

        if(isset($_SESSION['user']))
        {
            ?>
            <div class='navUser'>
                <div class='blockUser'>
                <div class='user_name'>          
                    <?php echo $_SESSION['user']->prenom_User; ?>
                </div>
                <img src=<?php echo $picture;?> alt='' />
                </div>

                <!--Sous Menu-->
                <ul class='sousMenu'>
                <li><a href='<?php echo $profile;?>'>  Profile </a></li>
                <li><a href='#2'>  Setting </a></li>
                <li><a href='#3'>  Choix 3 </a></li>
                <li><a href="?action=logout"> Log Out </a> </li>
                </ul>
            </div>
        <?php
        }
        else echo "<a href=".$signup."><button class='btnStyle2 btnSignup'>Inscrire</button></a>";
            ?>
    </div>  <!--End Container-->
</nav>