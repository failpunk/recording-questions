
/*-- Resize texarea
---------------------------------*/

$('textarea.resizable:not(.processed)').TextAreaResizer();
$('iframe.resizable:not(.processed)').TextAreaResizer();


/*-- Close popup
---------------------------------*/

$('.close a').click( function (){
	
	$('#alertTop').fadeOut(500);
	
	return false;
	
});


/*-- Add and Sub sidebar icons
---------------------------------*/

$('#recentTags li span a').click(function () {
	
	$(this).parent().parent().children('span').children('a').removeClass('active');
										   
	$(this).addClass('active');
	
	return false;

});


/*-- Show and Hide Comments
---------------------------------*/

$('.wrap-post .comments').hide();

$('.best-answer .comments').show();

$('.show-comments').click(function (){
	$(this).toggleClass('expanded');

	if ( $(this).hasClass('expanded') ) $(this).text('Hide Comments');
	else $(this).text('Show Comments');
	
	$(this).next().slideToggle(200);
})
