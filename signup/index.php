<!-- Header -->

<?php
    require("../init.php"); 
    if(isset($_SESSION['user']))
        header("location:$home");    
?>

<link rel='stylesheet' href='../css/globale.css' />
<link rel='stylesheet' href='css/signUp.css' />
<title>Signup in MyDictionary</title>

<!-- Content -->
    

    <!-- formGlb ==> The style of the form is global-->
    <form action="../redirect.php?type=sign" method='POST' class='formGlb signup'>  
        
        <img src='../images/user.png' alt='' class='user'/>
        
        <div class='required'>
            <input type='text' name='firstname' placeholder='First Name'/>
        </div>
        
        <div class='required'>
            <input type='text' name='lastname' placeholder='Last Name'/>
        </div>
        
        <div class='required'>
            <input type='text' name='username' placeholder='Username' />
        </div>
        
        <div class='required'>
            <input type='text' name='email' placeholder='Email' />
        </div>
        
        <div class='required'>
            <input type='password' class='password' name='password' placeholder='Password'/>
        </div>
        
        <input type='submit' name='signup' value='Sign Up' title='Sign Up'/>
    </form>








<!-- JavaScript / jQuery-->
<script src='../js/jquery-3.3.1.min.js'></script>
<script src='../js/globale.js'></script>
<script src='../js/globale2.js'></script>



<!-- Footer -->
<?php require($footer);?>