/* 
 * Javascript for the ask a new question page.
 */

$().ready(function()
{
    $("#title").focus();

    $('#title').keyup(function() {
        titleValidation();
    });

    $('#notify_checkbox').click(function()
    {
        $("#notify_email").toggleClass('disable');
    });

});

function titleValidation(element)
{
    // check title length
    var length = $('#title').val().length;
    if(length > 0 && length < 10) {
        displayTitleError('Please enter at least 10 characters');
    } else {
        displayTitleError('');
    }
}

function displayTitleError(msg) {
    $("#title").next().text(msg);
}

function toggleNotifyEmailCheckbox(checkbox)
{
    var input = $(checkbox).next();
    alert(input);
    
}