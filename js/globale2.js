$(document).ready(function()
{
    // My fn Center
    $.fn.myCenter = function()
    {
        $(this).css
        ({
            position:'relative',
            left: ($(this).parent().width() - $(this).width()) / 2
        });
    }



    //Tab header Click show ( sous Menu )
    $('.navGlb div >ul >li:not(.li_login)').click(show_SousMenu);

    $(".navGlb .li_login").hover(show_SousMenu);

    function show_SousMenu(event)
    {
        $(this).toggleClass('active').siblings('.active').removeClass('active');

        $(this).children('i').toggleClass('fa-angle-down fa-angle-up')

        $(this).siblings().each(function()
        {
           $(this).find('>a i').removeClass('fa-angle-up').addClass('fa-angle-down');
        });
    }


});


//-------------------- Show Bottom Light -----------------------
function showBottomLight()
{
    //Add The Bleu Light
    $("body").append("<div id='bottomLight' class='bottomLight'></div>");

    $("#bottomLight").slideDown(1000).delay(1000).slideUp(1000);

    //Remove it
    setTimeout(function()
    {
        $("#bottomLight").remove();
    },1000);
}
//------------------------------------------------------
