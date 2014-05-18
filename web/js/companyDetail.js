/* 
 * Javascript for the company detail page.
 */

$().ready(function()
{
   // show about form
    $('#company-about-info .edit-link').click(function()
    {
        $('#company-about-info').hide();
        $('#company-about-edit').show();
        return false;
    });
    
    // hide about form
    $('#company-about-edit-form input.cancel').click(function()
    {
        $('#company-about-edit').hide();
        $('#company-about-info').show();
        return false;
    });

    $('#company-about-edit-form input.save').click(function()
    {
        var form = $("#company-about-edit-form");

        $(".ajax-loader").show();
        $(form).find('input.save').val('Saving...');
        
        var result = validateCompanyAboutForm();

        if(result)
        {
            $.post
            (
                $("#update-about-route").val(),
                {
                    companyid: form.find("#companyid").val(),
                    url: form.find("#url").val(),
                    abouttext: form.find("#abouttext").val()
                },
                function(result)
                {
                    $(".ajax-loader").hide();
                    $(form).find('input.save').val('Submit');
                    
                    if(result.status) {
                        var href = form.find("#url").val();
                        var link = '<a rel="nofollow" href="' + href + '">'+ href + '</a>';
                        $(".company-about-website").html(link);
                            
                        $("#company-about-info-about").html(convertToBr(form.find("#abouttext").val()));   // update page with new about text
                        $('#company-about-edit-form input.cancel').click();
                    } else {
                        form.find("#abouttext").next().text(result.message);
                    }
                },
                "json"
            );
        }

        return false;
    });

    function validateCompanyAboutForm()
    {
        var validate = true;
        var summary = $("#company-about-edit-form #abouttext");
        var website = $("#company-about-edit-form #url");

        var words = countWords(summary.val());

        var url = jQuery.trim(website.val());
        if(url.substring(0,7) != 'http://' && url != '') {
            validate = false;
            website.next().text("Please make sure you enter a valid url (http:// ...)");
        } else {
            website.next().text("");
        }

        if(words < 1) {
            validate = false;
            summary.next().text("The about section can not be left blank");
        } else {
            summary.next().text("");
        }

        return validate;
    }
});