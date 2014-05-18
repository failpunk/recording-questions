/* 
 * Javascript for the question detail page.
 */

$().ready(function()
{
    // show add to studio options
    $('#add-to-profile').click(function() 
    {
        var status = $(this).attr('class');

        if($("#user-signed-in").val() == 'false') {
            $("#gear-post-tooltip").fadeIn(500);
            return false;
        }

        // show add to studio options if not yet selected
        if(status == 'favorite2') {
            $("#add-to-profile-options").fadeIn(500);
        }

        // othewise remove from studio
        if(status == 'favorite')
        {
            postAddToStudio($("#add-to-profile-gear-id").val(), 'remove', false);
        }

        return false;
    });

    // show and hide gear info tabs
    $('#gear-info a').click(function()
    {
        var id = $(this).attr("id");
        var section = id.split("-");

        // hide all tabs
        $("#about-tab-section").hide();
        $("#specs-tab-section").hide();
        $("#reviews-tab-section").hide();
        $("#discuss-tab-section").hide();

        // show the current tab
        $("#" + id + "-section").show();

        // set active tag
        $("#gear-info a").removeClass();
        $(this).addClass("active");

        // Change section title
        $("#gear-section-title").text(section[0]);

        if($(this).attr("id") != "about-tab") {
            $("#related-info").hide();
        } else {
            $("#related-info").show();
        }

        // Hide any visible forms
        $('#update-about-section-form').hide();
        $('#update-specs-section-form').hide();

        return false;
    });

    // grabs the ownership type and passes it to the post request
    $('#add-to-profile-options ul li a').click(function()
    {
        $('#add-to-profile-options').hide();

        var ownership = $(this).text();

        postAddToStudio($("#add-to-profile-gear-id").val(), 'add', ownership);

        return false;
    });

    // show site review form
    $('.new-site-review').click(function()
    {
        // clear review form
        $(".best-answer.submission input.text").val("");
        $(".best-answer.submission textarea").val("");

        $("#add-site-review").show();
        return false;
    });

    // hide site review form
    $('#site-review-cancel').click(function()
    {
        // clear review form
        $(".best-answer.submission input.text").val("");
        $(".best-answer.submission textarea").val("");

        $("#add-site-review").hide();
        return false;
    });
    
    // show user review form
    $('.new-user-review').click(function()
    {
        $("#add-user-review").show();
        return false;
    });

    // hide user review form
    $('#user-review-cancel').click(function()
    {
        $("#add-user-review").hide();
        return false;
    });

    // Executed when the submit button for site review is clicked
    $('#add-site-review-form input.save').click(function()
    {
        var form = $("#add-site-review-form");
        
        $(".ajax-loader").show();
        $(form).find('input.save').val('Saving...');

        var result = validateSiteReviewForm();

        if(result)
        {
            $.post
            (
                $("#add-site-review-route").val(),
                {
                    url: $(form).find("input#url").val(),
                    date: $(form).find("input#date").val(),
                    title: $(form).find("input#title").val(),
                    summary: $(form).find("textarea#summary").val(),
                    gearid: $(form).find("input#gearid").val()
                },
                function(result) {
                    // Restore the Loading indicators
                    $(".ajax-loader").hide();
                    $(form).find('input.save').val('Submit');
                    
                    // Hide the submit form
                    $("#add-site-review").hide();
                    $("#site-review-section").append(result);
                },
                "html"
            );
        }

        return false;
    });

    // handle submitting the user review form
    $('#add-user-review-form input.save').click(function()
    {
        var form = $("#add-user-review-form");
        
        $(".ajax-loader").show();
        $(this).val('Saving...');
        var result = validateUserReviewForm();

        if(result)
        {
            $.post
            (
                $("#add-user-review-route").val(),
                {
                    title: $(form).find("input#title").val(),
                    summary: $(form).find("textarea#summary").val(),
                    review: $(form).find("textarea#review").val(),
                    gearid: $(form).find("input#gearid").val()
                },
                function(result) {
                    // Restore the Loading indicators
                    $(".ajax-loader").hide();
                    $(this).val('Submit');

                    // Hide the submit form
                    $("#add-user-review").hide();
                    $("#user-review-section").append(result);
                },
                "html"
            );
        }

        return false;
    });

    function validateSiteReviewForm()
    {
        var validate = true;

        var url = $("#add-site-review-form #url");
        if($(url).val() == "") {
            validate = false;
            $(url).next().text("Please enter the url of the review you wish to add");
        } else {
            $(url).next().text("");
        }

        var date = $("#add-site-review-form #date");
        if($(date).val() == "") {
            validate = false;
            $(date).next().text("Please enter the date the review was published (MM/DD/YYYY)");
        } else {
            $(date).next().text("");
        }

        var title = $("#add-site-review-form #title");
        if($(title).val() == "") {
            validate = false;
            $(title).next().text("Please enter a title for this review");
        } else {
            $(title).next().text("");
        }

        var summary = $("#add-site-review-form #summary");
        if($(summary).val() == "" || countWords($(summary).val()) > 100) {
            validate = false;
            $(summary).next().text("Please enter a summary no more than 100 words");
        } else {
            $(summary).next().text("");
        }

        return validate;
    }

    function validateUserReviewForm()
    {
        var validate = true;

        var title = $("#add-user-review-form #title");
        if($(title).val() == "") {
            validate = false;
            $(title).next().text("Please enter a title for your review");
        } else if($(title).val().length < 20) {
            validate = false;
            $(title).next().text("Title should be at least 25 characters");
        } else {
            $(title).next().text("");
        }

        var summary = $("#add-user-review-form #summary");
        if($(summary).val() == "" || countWords($(summary).val()) > 50) {
            validate = false;
            $(summary).next().text("Please enter a summary no more than 50 words");
        } else {
            $(summary).next().text("");
        }

        var review = $("#add-user-review-form #review");
        if($(review).val() == "" || countWords($(review).val()) < 100) {
            validate = false;
            $(review).next().text("Please enter a review of at least 100 words");
        } else {
            $(review).next().text("");
        }

        return validate;
    }

    // ajax update
    function postAddToStudio(gearid, action, ownership)
    {
        $.post
        (
            $("#add-to-profile-route").val(),
            {gear_id: gearid, ownership: ownership, execute: action},
            function(result) {
                  updateStudioAdd(result);
            },
            "json"
        );
    }

    // updates the page with the post result
    function updateStudioAdd(result)
    {
        var statusText = "";

        if(result.execute == 'add')
        {
            if(result.status)
            {
                $('#add-to-profile').attr('class', 'favorite');
                statusText = result.status;
            }
            else
            {
                $('#add-to-profile').attr('class', 'favorite2');
                statusText = "";
            }
        }
        else
        {
            if(result.status)
            {
                $('#add-to-profile').attr('class', 'favorite2');
                statusText ="";
            }
            else
            {
                $('#add-to-profile').attr('class', 'favorite');
                statusText = result.status;
            }
        }
        
        $("#ownership-status").text(statusText);
    }

    $('#add-site-review-form #summary').keyup(function()
    {
        var wordCount = countWords($(this).val());
        var element = $(this).parent().parent().prev().children().children();

        $(element).text(100 - wordCount);
        if((100 - wordCount) < 1) {
            $(element).css("color", "#990000");
        } else {
            $(element).css("color", "#999999");
        }
        
    });
    
    $('#add-site-review-form #title').keyup(function()
    {
        if($(this).val().length < 20) {
            $(this).next().text("Title should be at least 25 characters");
        } else {
            $(this).next().text("");
        }
    });
    
    $('#add-user-review-form #summary').keyup(function()
    {
        var wordLimit = 50;
        var wordCount = countWords($(this).val());
        
        if(wordCount > wordLimit) {
            $(this).parent().parent().prev().children().text('You have exceeded the maximum of ' +wordLimit+ ' words').css("color", "#990000");
        }
        else
        {
            $(this).parent().parent().prev().children().html('Words Remaining <span></span>').css("color", "#999999");
            var element = $(this).parent().parent().prev().children().children();
            $(element).text(wordLimit - wordCount);
            if((wordLimit - wordCount) < 1) {
                $(element).css("color", "#990000");
            } else {
                $(element).css("color", "#999999");
            }
        }
    });
    
    $('#add-user-review-form #review').keyup(function()
    {
        var wordLimit = 100;
        var wordCount = countWords($(this).val());

        if(wordCount >= wordLimit) {
            $(this).parent().parent().prev().children().text('You now have enough words to publish your review.').css("color", "#627A37");
        }
        else
        {
            $(this).parent().parent().prev().children().html('Min of ' +wordLimit+ ' Words | <span></span>').css("color", "#999999");
            var element = $(this).parent().parent().prev().children().children();

            $(element).text(wordLimit - wordCount + ' of ' + wordLimit + ' remaining');
            if((wordLimit - wordCount) < 1) {
                $(element).css("color", "#990000");
            } else {
                $(element).css("color", "#999999");
            }
        }
    });

    // shows an error message if title is not at least 20 characters long
    $('#add-user-review-form #title').keyup(function()
    {
        if($(this).val().length < 20) {
            $(this).next().text("Title should be at least 25 characters");
        } else {
            $(this).next().text("");
        }
    });

    // Cast a vote for an offensive post
    $('#reviews-tab-section a.flag-post').click(function()
    {
        var post_id = $(this).prev("input#review_id").val();

        if(confirm('Are you sure you want to flag this post as offensive or spam?'))
        {
            $.post
            (
                $("#add-offensive-route").val(),
                {
                    postid: post_id,
                    type: 'gear_review'
                },
                function(result) {
                      if(!result.status) {
                          alert(result.message);
                      }
                },
                "json"
            );
        }
        return false;
    });


    // EDIT ABOUT AND SPECS

    // show about/stats form
    $('.gear-stats p.edit-link a').click(function()
    {
        $(this).parents('.gear-stats').hide();
        $(this).parents('.gear-stats').next().show();
        return false;
    });

    // hide about/stats form
    $('form p.submit input.cancel-a').click(function()
    {
        $(this).parent().parent().hide();
        $(this).parents('form').prev().show();
        return false;
    });

    $('#update-specs-section-form').submit(function()
    {
        //todo add validation
        var result = true;
        
        if(result)
        {
            postSpecsForm();
        }

        return false;
    });

    $('#update-about-section-form').submit(function()
    {
        var result = validateAboutForm();

        if(result)
        {
            postAboutForm();
        }

        return false;
    });


    function validateAboutForm()
    {
        var validate = true;
        var textField = $("#about-section-text");
        var words = countWords(textField.val());

        if(words > 400) {
            validate = false;
            textField.next().next().text("Please enter a maximum of 400 words in the about section");
        } else if(words < 1) {
            validate = false;
            textField.next().next().text("The about section can not be left blank");
        }

        return validate;
    }

    function postAboutForm()
    {
        $.post
        (
            $("#update-about-route").val(),
            {
                abouttext: $("#about-section-text").val(),
                gearid: $("input#gearid").val()
            },
            function(result)
            {
                if(result.status) {
                    var text = convertToBr($("#about-section-text").val());
                    $("#edit-about-link").children('.date1').next().html(text);   // update page with new about text
                    $('#cancel-about-submit').click();
                } else {
                    $("#about-section-text").next().next().text(result.message);
                }
            },
            "json"
        );
    }

    function postSpecsForm()
    {
        $.post
        (
            $("#update-specs-route").val(),
            {
                specstext: $("#specs-section-text").val(),
                gearid: $("input#gearid").val()
            },
            function(result)
            {
                if(result.status) {
                    var text = convertToBr($("#specs-section-text").val());
                    $("#edit-specs-link").children('.date1').next().html(text);   // update page with new about text
                    $('#cancel-specs-submit').click();
                } else {
                    $("#specs-section-text").next().next().text(result.message);
                }
            },
            "json"
        );
    }

    // Get the full user review text from DB
    $(".review-read-more").click(function()
    {
        var element = $(this);
        element.text("Loading...");

        $.post
        (
            element.attr('href'),
            {
            },
            function(result)
            {
                if(result) {
                    var paragraph = "<p>" + result + "</p>";
                    element.parent().parent().after(paragraph);
                    element.hide();
                }
            },
            "html"
        );
        return false;
    });

    // GEAR LISTINGS

    // Add a piece of gear to studio from gear list.
    $('ul.tags.add-gear a.add-to-studio').click(function()
    {
        $(this).parent().next().fadeIn(500);

        return false;
    });

    $('ul.tags.add-gear a.choice').click(function()
    {
        var ownership = $(this).text();
        var gearid = $(this).parent().parent().parent().parent().children(':last-child').val();
        
        postAddToStudio(gearid, 'add', ownership);

        $(this).parent().parent().fadeOut(500);
        $(this).parent().parent().prev().html('Your studio is growing!');

        return false;
    });

    $('.head-tabs a.right-link.members').click(function()
    {
        if($(this).hasClass('own'))
        {
            $('#gear-owners-own').hide();
            $('#gear-owners-want').show();
        }
        else
        {
            $('#gear-owners-want').hide();
            $('#gear-owners-own').show();
        }

        return false;
    });
});