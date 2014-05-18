/* 
 * Javascript for the Add New Gear page.
 */

$().ready(function()
{
    jQuery(".company-complete").autocomplete($("#find-company-route").val(), {
        use_style: true
    }).result(function(event, data, formatted) {
        $(this).parent().next().show();
    });

    jQuery("#gearname").autocomplete($("#find-gear-route").val(), {
        use_style: true
    }).result(function(event, data, formatted) {
        $("#gear-div .step-4").show();
    });

    // remove directions from search box
    $('.text.ac_input').focus(function()
    {
        if($(this).val() == "Start typing here...") {
            $(this).val("");
        }
    });

    // remove directions from search box
    $('.text.ac_input').blur(function()
    {
        if($(this).val() == "") {
            $(this).val("Start typing here...");
        }
    });
    
    /*
     * JS to display the gear add elements
     */
    $('#type').change(function()
    {
        if($(this).val() == "Gear")
        {
            $("#company-div").hide();
            $("#gear-div").show();
        }
        else
        {
            $("#gear-div").hide();
            $("#company-div").show();
        }

        $("#gear-div .step-1").show();
        return false;
    });

    $('#gear-div .step-1').change(function()
    {
        $("#gear-div .step-2").show();
        return false;
    });

    $('#gear-div .step-2 input').blur(function()
    {
        $("#gear-div .step-3").show();
        return false;
    });

    $('#gearname').blur(function()
    {
        $("#gear-div .step-4").show();
        return false;
    });

    $('#continue-gear-add').click(function()
    {
        $("#gear-div .step-5").show();
        return false;
    });

    // displays number of words remaining to user
    $('textarea').keyup(function()
    {
        var wordLimit = 400;
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
    
    $('.upload-image').click(function()
    {
        var element = $(this);
        if($(this).prev().val() != '')
        {
            $("#image-upload .ajax-loader").show();
            
            $.post
            (
                $("#upload-file-route").val(),
                {
                    image_url: $(this).prev().val()
                },
                function(result) {
                    $("#image-upload .ajax-loader").hide();
                    if(result.status)
                    {
                        element.parent().find("#dynamic-image-preview").remove();
                        
                        var img = '<div id="dynamic-image-preview"><img class="image-preview" src="/uploads/' + result.name + '"/><br/><span>Not happy with this image?  Just upload another.</span></div>'
                        element.parent().append(img);
                        element.parent().next().val(result.name);

                        // if this is the update image page, show submit button
                        $("#submit_gear_button").show();
                    }
                    else
                    {
                        $("#image-upload p.error").text(result.message);
                    }
                },
                "json"
            );
        }
        return false;
    });

    $('#gear-add-to-db-form').submit(function()
    {
        $('#submit_gear_button').val('Saving...');
        $(".ajax-loader").show();

        var result = validateGearForm($(this));

        if(result)
        {
            return true;
        }

        $(".ajax-loader").hide();
        $('#submit_gear_button').val('Submit New Gear');
        return false;
    });

    function validateGearForm(form)
    {
        var validate = true;

        var company = $(form).find("input#company");
        if($(company).val() == "" || $(company).val() == 'Start typing here...') {
            validate = false;
            $(company).next().next().text("Please enter the company that makes this piece of gear");
        } else {
            $(company).next().next().text("");
        }

        var gear = $(form).find("input#gearname");
        if($(gear).val() == "" || $(gear).val() == 'Start typing here...') {
            validate = false;
            $(gear).next().next().text("Please enter the name of the new piece of gear");
        } else {
            $(gear).next().next().text("");
        }

        var about = $(form).find("textarea#about-gear");
        if($(about).val() == "") {
            validate = false;
            $(about).next().text("Please enter a summary of what this gear does (no more than 400 words)");
        } else if(countWords($(about).val()) > 400) {
            validate = false;
            $(about).next().text("Please use no more than 400 words");
        } else {
            $(about).next().text("");
        }

        var imageName = $("#upload-image-file-name");
        if($(imageName).val() == "") {
            validate = false;
            $("#image-upload").find("p.error").text("Please upload an image of this piece of gear (just put the URL of the image on the web)");
        } else {
            $(imageName).next().next().text("");
        }

        return validate;
    }

    // show next step
    $('#company-div .step-2 input').blur(function()
    {
        $("#company-div .step-3").show();
        return false;
    });
});