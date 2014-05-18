/* 
 * Javascript for the question detail page.
 */

$().ready(function()
{
    // show switch text link to say loading
    $('.show-comments').click(function() {
        $(this).text('Loading...');
    });

    // show message to users trying to answer own question
    $('#answer-own-question').click(function() {
        $(this).next().fadeIn(250);
    });

    // show lock question options
    $('#question-lock').click(function() {
        $("#question-lock-options").fadeIn(500);
        return false;
    });

    // Show the actual answer question form
    $('#answer-show-form').click(function() {
        // fix to make sure tinyMCE is the right size after bing shown
        $('#answer_tbl').css('width', '597px')
        $('#answer_tbl').css('height', '207px')
        $(this).parent().hide();
        $('#answer-own-question').hide();
        $(this).parent().next().show();
        return false;
    });

    // When reason for locking question is selected, set value with js
    $('#question-lock-options ul li a').click(function()
    {
        var lock_reason = $(this).text();
        $("#question-lock-reason").val(lock_reason);

        if(lock_reason == 'It is a duplicate question')
        {
            $("#question-lock-duplicate").show();
            return false;
        }

        $("#question-lock-form").submit();
    });

    // submit question lock form when submit link for question id is clicked
    $('#question-lock-duplicate a').click(function()
    {
        $("#question-lock-form").submit();
    });

    // submit question lock form when submit link for question id is clicked
    $('.send-tweet').click(function()
    {
        $.post
        (
            $("#send-tweet-route").val(),
            {
                type: 'question',
                key: $(this).attr("tweet")
            },
            function(result) {
                if(result.result)
                    alert('Thanks for sharing this question on twitter!  This question should show up in your twitter feed shortly.');
                else
                    alert('There was a problem sending the tweet.  Twitter could be experiencing a heavy load right now, wait a few moments and try again.');
            },
            "json"
        );
        return false;
    });

});

// pass in an owner name and this will highlight all the posts on the page
function HighlightUserPosts(displayName, hexColor)
{
    // check for comments
    $('ul.comments li p.info-user a').filter(function()
    {
      if($(this).text() == displayName)
      {
          $(this).parent().parent().addClass('owner');
      }
    });


    // check for answers
    $('ol.comments li div.info p.dates a').filter(function()
    {
      if($(this).text() == displayName)
      {
          $(this).parent().parent().addClass('owner');
      }
    });
}

