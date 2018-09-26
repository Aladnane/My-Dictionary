$(document).ready(function()
{
    var index, classSave, classFav,fWord,sWord;


    //Afficher Traduciton de l'index Envoyé
    function show_Trad(index)
    {
        //Determiner la Traduction
        tr = $("tr[data-index='"+index+"']");
        
        //Les Mots
        fWord = tr.children(".firstLang").text();
        sWord = tr.children(".secondLang").text();
        //les Icons
        classSave = tr.find(".garder i").attr("class");
        classFav = tr.find(".favorite i").attr("class");
        
        //Affectation
        $(".popupTrad .words h2:first-of-type").text(fWord);
        $(".popupTrad .words h2:last-of-type").text(sWord);

        $(".popupTrad .options .save").attr('class',classSave);
        $(".popupTrad .options .favorite").attr('class',classFav);

        //les Icons de Passage (To Left - To Right)
        popupIndex = $('.popupTrad').attr("data-index");
        length_trad = $("#tableWords").attr("data-length");

        iconLeft = $(".popupTrad .words i.left");
        iconRight = $(".popupTrad .words i.right");
        
        //Left
        if(popupIndex > 0)
            iconLeft.addClass("fas fa-angle-left");
        else if(popupIndex == 0)
            iconLeft.removeClass("fas fa-angle-left");

        //Right
        if(popupIndex < length_trad-1)
            iconRight.addClass("fas fa-angle-right");
        else if(popupIndex == length_trad-1)
            iconRight.removeClass("fas fa-angle-right");

    }

    //Afficher La Traduciton
    $("#tableWords tr td:not('.icon')").click(function()
    {
        
        index = $(this).parent().attr("data-index");
        
        $(".popupTrad").attr("data-index",index);

        show_Trad(index); //Affecter Les Inforamtion de La Traduction

        //Les Langues
        lang1 = $("#lang1").text();
        lang2 = $("#lang2").text();

        //Affercter Les Langues
        $(".popupTrad .titre h2:first-of-type").text(lang1);
        $(".popupTrad .titre h2:last-of-type").text(lang2);
        
        
        //Afficher La Boit de La traduction
        $(".popupTrad").fadeIn();
    });


    //-----------------------------------Function Sauvgarder
    function save_trad(icon)
    {
        icon.toggleClass("far fas");

        icon.parent().parent().toggleClass("saveChanged");

        if(icon.next("input").attr("value") == "")
            icon.next("input").attr("value","garder");
        else
            icon.next("input").attr("value","");

        //Show Options( Save - Cancel)
        $(".options").slideDown();
    }

    //button Save in Globale Table
    $(".garder i").click(function()
    {
        save_trad($(this));
    });
    //-------------------------------------------------------

    //-----------------------------------Function Delete 
    function remove_trad(icon)
    {
        var tr = icon.parent().parent();
        tr.toggleClass("rmv");//sauvgarder les ancienne Color des Icon (sauvgarder, Faorite, remove)

        if(icon.next("input").attr("value") == "")
            icon.next("input").attr("value",'remove');
        else
            icon.next("input").attr("value",'');

        //Show Options( Save - Cancel)
        $(".options").slideDown();
    }
    
    //button Remove in Globale Table
    $(".remove i").click(function()
    {
        remove_trad($(this));
    });
    //-------------------------------------------------------

    
    //-----------------------------------Function Favorite
    function favorite_trad(icon)
    {
        var tr = icon.parent().parent();
        tr.toggleClass("fav");

        var value = icon.next("input").attr("value");

        if(value == "noFav" || value == "noFav-changed")
            icon.next("input").attr("value",'Fav');
        else
            icon.next("input").attr("value",'noFav-changed');

        icon.toggleClass("fas far fav-Changed");

        //Show Options( Save - Cancel)
        $(".options").slideDown();
    }
    
    //button Remove in Globale Table
    $(".favorite i").click(function()
    {
        favorite_trad($(this));
    });
    //-------------------------------------------------------
    
    //-------------------------------Popup Afficher La Traduction
    
    // La Boit de Traduction (button Save)
    var index, icon, index_Trad;

    $(".popupTrad .words i").click(function()
    {
        index_Trad = $(".popupTrad").attr("data-index");

        if($(this).hasClass('left')) index_Trad--;
        else index_Trad++;

        $(".popupTrad").attr("data-index",index_Trad);//new Index
        
        show_Trad(index_Trad);
    });

    $(".popupTrad .options .save").click(function()
    {
        index = $(this).parent().parent().parent().attr('data-index');
        icon = $("tr[data-index='"+index+"'] .garder i");
        save_trad(icon);

        $(this).toggleClass("far fas");
    });
    
    // La Boit de Traduction (button Remove)
    $(".popupTrad .options .remove").click(function()
    {
        index = $(this).parent().parent().parent().attr('data-index');
        icon = $("tr[data-index='"+index+"'] .remove i");
        remove_trad(icon);
    });

    // La Boit de Traduction (button Favorite)
    $(".popupTrad .options .favorite").click(function()
    {
        index = $(this).parent().parent().parent().attr('data-index');
        icon = $("tr[data-index='"+index+"'] .favorite i");
        favorite_trad(icon);

        $(this).toggleClass("fas far");
    });

    
    //-----------------------------------Fin Popup


    //Cancel Button
    $(".tblGest .cancel").click(function(e)
    {
        e.preventDefault();

        $(".rmv").each(function()
        {
            $(this).find(".remove i").click();
        });

        $(".saveChanged").each(function()
        {
            $(this).find(".garder i").click();
        });

        $(".fav-Changed").each(function()
        {
            $(this).click();
        });
    });


    //Fermer La Boit de Traduction
    $(".popupTrad .background, .popupTrad .close").click(function()
    {
        $(".popupTrad").fadeOut();
    })


    
    
    
    
    
    
});