$(document).ready(function()
{
    //Choisir le type (Mot / verbe / No Determiné)
    $(".comboBox .types li").click(function(event)
    {
        var value = $(this).attr("data-value");
        
        $(this).parent().prev(".title").attr('data-choix',value)
               .children('span').text(value);
        $(this).parent().slideUp();
    });
    
    
    //button Ajouter au Tableau (La Verification Puis l'Addition dans le tableau)
    var languages = ["Arabic","Frensh","English","Spanish","Chinese"],
        types     = ["Une Mot","Un Verbe","No Determiné"];
    
    
    var indexN = 0;
    
    $("#btnAdd").click(function()
    {
        //Afficher le tableau Des Mots        
        if($(".wordsInserted").hasClass("hidden"))
            $(".wordsInserted").removeClass("hidden");

        var
            fWord = $("input[name='fWord']").val(),
            sWord = $("input[name='sWord']").val(),
            type = $("#typeWord").attr('data-choix');
                
        $("input[name='fWord']").val("");
        $("input[name='sWord']").val("");

        var  
        line = "<tr>   ";
        line +=    "<td class='favorite'>";
        line +=       "<i class=\"far fa-star\"></i>";
        line +=       "<input type='hidden' name='fav-"+indexN+"' value='noFav' class='input_fav' />";
        line +=   " </td>";
        
        line +=    "<td class='firstLang'>";
        line +=       fWord;
        line +=       "<input type='hidden' name='fWord-"+indexN+"' value='"+fWord+"' class='input_fWord' />";
        line +=    "</td>";
        
        line +=    "<td class='secondLang'>";
        line +=         sWord
        line +=       "<input type='hidden' name='sWord-"+indexN+"' value='"+sWord+"' class='input_sWord' />";
        line +=    "</td>";
        
        line +=    "<td class='type'>";
        line +=        type
        line +=       "<input type='hidden' name='type-"+indexN+"' value='"+type+"' class='input_type' />";
        line +=    "</td>";
        
        line +=    "<td class='desciption'>";
        line +=         "This is the Description";                    
        line +=         "<input type='hidden' name='description-"+indexN+"' value='This is the Description' class='input_desc'/>";   
        line +=    "</td>";       
        
        line +=    "<td class='remove'>";
        line +=        "<i class=\"fas fa-trash-alt remove\"></i>";
        line +=    "</td>";
        line +="</tr>";

         indexN++;  //l'index de Mots (identifiant de '$_POST[name + 0]')   
            
        $("#tableWords").append(line);
        
        showBottomLight();
    });
    
    //Changer La Langue (Afficher La List des Langues)
    $(".chooseLang button").click(function()
    {
        var lastLangue = $(this).attr("data-lang"),btn;
                
        btn = $(this).attr('id') == "firstLang" ? "btn1" : "btn2";
        
        $(".popupLang").attr(
            {
                'source'  :lastLangue,
                'btnIndex':btn
            }).fadeIn();
    });
    
    //Changer L'ancienne langue par la nouveau
    $(".popupLang div.lang").click(function()
    {
        var source = $(".popupLang").attr('source'),
            newLang = $(this).attr('data-val');
        
        $("button[data-lang='"+source+"']").text(newLang)
                .attr("data-lang",newLang);
        
        if(($(".popupLang").attr('btnindex') == "btn1") && ($("#secondLang").attr('data-lang') == newLang))
        {
            $("#secondLang").attr('data-lang',source).text(source);
        }
        else if(($(".popupLang").attr('btnindex') == "btn2") && ($("#firstLang").attr('data-lang') == newLang))
        {
            $("#firstLang").attr('data-lang',source).text(source);
        }
        
        
        $(".popupLang").fadeOut();
        
        reinitialiserLangs(); 
    });
    
    //Close The Popup
    $(".popupLang div:first-of-type").click(function()
    {
        $(".popupLang").fadeOut(); 
    });
    
    
    //inverser les Langues  (Permutation des Langues)
    $(".changelang i").click(function()
    {
        var firstLang = $("#firstLang").attr('data-lang'),
            secondLang = $("#secondLang").attr('data-lang');
            
        $("#firstLang").attr('data-lang',secondLang).text(secondLang); 
        $("#secondLang").attr('data-lang',firstLang).text(firstLang); 
        
        //Inverser Le Mots
        var fWord = $("input[name='fWord']").val(),
            sWord = $("input[name='sWord']").val();

        $("input[name='fWord']").val(sWord);
        $("input[name='sWord']").val(fWord);

        reinitialiserLangs();        
    });
    
    //Favorite => Add a Word to The Favorite 
    $("body").on("click",".favorite i",function()
    {
        $(this).toggleClass("fas far");
        var input = $(this).siblings("input[type='hidden']");
        
        if(input.attr('value') == 'noFav')
            input.attr('value',"Fav");
        else
            input.attr('value',"noFav");
    });
    
    //remove a Word From The table
    $("body").on("click",".remove i.remove",function()
    {
            $(this).parent().parent("tr").remove();
            indexN--;

            var i = 0;
            
            $("#tableWords tr:not(:first-of-type)").each(function()
            {
                console.log("inside");
                console.log("i: "+i);

                $(this).find(".input_fav").attr("name","fav-"+i);
                $(this).find(".input_fWord").attr("name","fWord-"+i);
                $(this).find(".input_sWord").attr("name","sWord-"+i);
                $(this).find(".input_type").attr("name","type-"+i);
                $(this).find(".input_desc").attr("name","description-"+i);

                i++;
            });
    });

    
    //renisialiser les Langues dans le Site
    var reinitialiserLangs = function ()
    {
        var fLang = $("#firstLang").attr('data-lang'),
            sLang = $("#secondLang").attr('data-lang'),
            fZone  = $("input[name='fWord']"),
            sZone  = $("input[name='sWord']");
        
        fZone.attr("placeholder","Le Mot en '" + fLang+"'");
        sZone.attr("placeholder","Son Tradution en '" + sLang+"'");
        $("#fLangColumn").text(fLang);
        $("#sLangColumn").text(sLang);        

        $("#inputLang1").attr("value",fLang);        
        $("#inputLang2").attr("value",sLang);        
    }
    
    reinitialiserLangs();
    

    
    
});

    
    
    