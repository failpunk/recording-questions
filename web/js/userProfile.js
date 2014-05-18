/* 
 * Javascript for the question detail page.
 */

// pass in an owner name and this will highlight all the posts on the page
function togglePosts(element)
{
    if($(element).hasClass('expanded'))
    {
        $(element).removeClass('expanded');
        $(element).text('See All Posts');
    }
    else
    {
        $(element).addClass('expanded');
        $(element).text('Hide All Posts');
    }

    $(element).next().slideToggle(200);
}

$().ready(function()
{
   $('#user-studio-platform-select').change(function()
    {
        // show ajax icon
        var select = $(this);
        select.next().next().show();

        $.post
        (
            $("#user-studio-platform-select-route").val(),
            {
                platform: $(this).val()
            },
            function(result) {
                if(result.status) {
                    // update platform text
                    select.prev().prev().text(select.val().toUpperCase());
                }

                // hide ajax icon and dropdown and cancel link, show change link
                select.next().next().hide();
                select.hide();
                select.next().hide();
                select.prev().show();
            },
            "json"
        );
        return false;
    });

    $('#user-studio-platform-change').click(function()
    {
        $(this).next().show();
        $(this).next().next().show();
        $(this).hide();
        return false;
    });

    $('#user-studio-platform-cancel').click(function()
    {
        $(this).hide();
        $(this).prev().hide();
        $(this).prev().prev().show();
        return false;
    });

    $('a#submit-twitter-link').click(function()
    {
        var element = $(this);
        element.text('Checking Twitter Credentials...');

        $.post
        (
            $("#submit-twitter-route").val(),
            {
                twittername: $('#twittername').val(),
                twitterpass: $('#twitterpass').val()
            },
            function(result)
            {
                if(result.status)
                {
                    twitterAccountAdded();
                }
                else
                {
                    $("#add-twitter-account .twitter-info .messageBox").fadeIn(500);
                    $('#twittername').css('color', '#990000');
                    $('#twitterpass').css('color', '#990000');
                    element.text('Add My Twitter Account! »');
                }
            },
            "json"
        );

        return false;
    });

    // hide and show sceen elements after adding twitter account
    function twitterAccountAdded()
    {
        $("#add-twitter-account div.twitter-info").hide();
        $("#add-twitter-account .confirmation").show();
    }

    // change the current twitter account (show screen controls)
    $('#change-twitter-account').click(function()
    {
        $(this).parent().hide();
        $("#add-twitter-account div.twitter-info").show();
        return false;
    });

    // toggle twitter account on and off
    $('#change-twitter-status').click(function()
    {
        var element = $(this);
        
        $.post
        (
            $("#change-twitter-status-route").val(),
            {
            },
            function(result)
            {
                element.prev().text(result.status);

                if(result.status == 'on') {
                    var text = 'off';
                } else {
                    var text = 'on';
                }

                element.text('turn ' + text);
            },
            "json"
        );

        return false;
    });

    // toggle twittering questions or questions and gear
    $('#change-twitter-type').click(function()
    {
        var element = $(this);

        $.post
        (
            $("#change-twitter-type-route").val(),
            {
            },
            function(result)
            {
                if(result.status == 'all') {
                    var text = 'Tweet about questions and gear';
                } else {
                    var text = 'Tweet about questions';
                }

                element.prev().text(text);
            },
            "json"
        );

        return false;
    });
});

