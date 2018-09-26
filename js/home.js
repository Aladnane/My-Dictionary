$(document).ready(function()
{


    //NavBar
    var etat;

    $(window).scroll(function()
    {
        if($(this).scrollTop() < 112 &&  $(".navGlb").hasClass('bottom'))
        {
            $(".navGlb").removeClass('bottom');
        }
        else if($(this).scrollTop() >= 100 && !$(".navGlb").hasClass('bottom'))
        {
            $(".navGlb").addClass('bottom');
        }

    });
    
    $(window).scroll();
    
    
    
    
    
    
    
});