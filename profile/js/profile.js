$(document).ready(function()
{


    //Les Etabs click(Show Details)
    $('.block .title').click(function()
    {
        $(this).toggleClass('active');
        $(this).next().slideToggle(400);
        $(this).children('i').toggleClass('fa-angle-down fa-angle-up');
    });




});