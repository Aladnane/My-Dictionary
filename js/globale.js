$(document).ready(function()
{

    //--------------  nav bar--------------------
    
    //show user Menu (subMenu from navbar)
    $('div.navUser > div').click(function(event)
    {
       $(this).siblings('ul.sousMenu').slideToggle(); 
    });
       
    //---------------------------------------------------

    
    //----------------- form Global ---------------------
    
    //Verifier Si Tous Les Chanps Sont Remplies
   $('.formGlb').submit(function(event)
   {
       $(this).find('input:not(.ignore)').each(function()
       {
           if($(this).val() == '')
               {
                   event.preventDefault();
                   $(this).addClass('inputErr');
               }
       });
   });

    
    //remplire les Champs qui sont Vide 
//    $('.formGlb input').keyup(function()
//    {
//        if(($(this).hasClass('inputErr'))&&($(this).val() != ''))
//        {
//            $(this).removeClass('inputErr');
//        }
//    });
    
    //---------------------------------------------------
    
    
    
    
    
    
    //-------------------Notification-----------------------
    
//    //Show The notification
//    $('.notify').animate
//    ({
//        top:"80px",
//        opacity:1
//    },1000);
//    
//    //Hide The notification
//    $('.notify').delay(3500).fadeOut(2000);
    
    //------------------------------------------------------
    
    //-------------------ComboBoxShow Sous menu--------------
    $('.comboBox .title').click(function()
    {
        $(this).siblings('ul').slideToggle(500); 
    });
    
    //------------------------------------------------------
    
    //-------------------- 'a' Inside 'li' ---------------------------
    $(".li_a, .sousMenu li").click(function()
    {
        var link = $(this).children("a").attr("href");
        location.href = link;
    });
    //------------------------------------------------------

    
    
    
    
    
    
    
    
    
    
    
    
});