function xclose(id)
{
    $("#"+id).fadeOut(500, function () {
        $(this).remove();
      });
}

function xhide(id)
{
    $("#"+id).fadeOut(500);
}


$(document).ready(function() {

    animatePopup();

    /*-- Close popup
    ---------------------------------*/

    $('.popup p.close').click( function (){

        $(this).parent().fadeOut(500);

        return false;

    });

});

/* If a popup message is displayed, animate it. */
function animatePopup()
{
    if( $(".popup").length > 0 ) {

        if($(".popup").hasClass('one')) {
            $(".popup").animate({ backgroundColor: "#C90000" }, "fast").animate({ backgroundColor: "#FBD5D5" }, "slow");
        }

        if($(".popup").hasClass('two')) {
            $(".popup").animate({ backgroundColor: "#93B05E" }, "fast").animate({ backgroundColor: "#EDFBD5" }, "slow");
        }
        
        if($(".popup").hasClass('three')) {
            $(".popup").animate({ backgroundColor: "#EDD800" }, "fast").animate({ backgroundColor: "#FFFFC0" }, "slow");
        }
    }
}

// counts the number of words in a string
function countWords(text)
{
    var y = text;
    var r = 0;
    a=y.replace(/\s/g,' ');
    a=a.split(' ');
    for (z=0; z<a.length; z++) {if (a[z].length > 0) r++;}
    return r;
}

// counts the number of words in a string
function convertToBr(text)
{
    return text.replace(/\n/g, '<br />');
}

$().ready(function()
{
    // show flag this options
    $('p.flag-gear a.flag-post').click(function()
    {
        $("#flag-gear-page-options").fadeIn(500);
        return false;
    });

    // post flag this options to database
    $('#flag-gear-page-options ul li a').click(function()
    {
        $("#flag-gear-page-options").hide();
        var reason = $(this).text();
        var element = $('#flag-gear-page-options');

        $.post
        (
            $("#flag-gear-page-route").val(),
            {
                type: $("#flag-gear-page-type").val(),
                id: $("#flag-gear-page-key").val(),
                reason: reason
            },
            function(result)
            {
                alert(result.message);
            },
            "json"
        );

        return false;
    });
});