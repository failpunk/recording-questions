<?php use_helper('Form', 'Tag', 'notification') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<?php include_title() ?>

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_slot('links'); ?>
    
<link type="text/css" rel="stylesheet" href="/min/f=css/style.css,css/gear.css,sfJqueryReloadedPlugin/css/JqueryAutocomplete.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="/min/f=js/custom.js,js/jquery.color.js,js/type_watch-2.0.js,sfJqueryReloadedPlugin/js/plugins/jquery.autocomplete-1.0.2.min.js,js/questionDetail.js,js/userProfile.js,js/askQuestion.js"></script>
<?php //echo include_stylesheets('style.css'); ?>

<?php //TODO: load jquery from google hosting ?>
<?php // echo javascript_include_tag('jquery.js') ?>
<?php // echo javascript_include_tag('textarearesizer.js') ?>
<?php // echo javascript_include_tag('default.js') ?>

<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/css/ie.css"><![endif]-->

<?php // Hide dev site from spiders ?>
<?php if($_SERVER['HTTP_HOST'] == 'martini.recordingquestions.com' || $_SERVER['HTTP_HOST'] == 'gnigats.recordingquestions.com'): ?>
<meta name="robots" content="noindex,nofollow">
<?php endif ?>

<meta name="verify-v1" content="KNDY0Vu6vCIMekolqOEMzwI/xcqiPumdsWqdbPugCbk=" />
<META name="y_key" content="71173c4465303e2b">
<meta name="msvalidate.01" content="082415576B355779386F05AB8D422340" />

<link rel="shortcut icon" href="/favicon.ico" />
</head>

<body class="<?php echo has_slot('home_page') ? 'home-page' : 'inner-page' ?>">

<div id="wrap">

<ul class="skip">
	<li><a href="#nav">Skip to Navigation</a></li>
	<li><a href="#content">Skip to Content</a></li>
</ul>

<div id="header">

<h1 id="logo"><a href="<?php echo url_for('homepage') ?>"
	title="Homepage">Recording Questions</a></h1>

<?php if(!has_slot('home_page')): ?> <?php echo form_tag("index/search", array('method' => 'get', 'class' => 'search', 'id' => 'search')) ?>

<p class="fields"><input name="search" id="searchField" type="text"
	class="text" value="Search for questions right here..."
	onfocus="this.value='';"
	onblur="if(!this.value)this.value='Search for questions right here...';" />

<input type="submit" value="Search" class="submit"></input></p>

</form>
<?php endif ?>

<ul class="nav" id="nav">

	<li class="questions"><a href="#">Questions</a>

	<ul>

		<li><?php echo link_to('Ask A Question', '@ask_question') ?></li>
		<li><?php echo link_to('Most Recent' ,'@homepage_nav?nav=recent') ?></li>
		<li><?php echo link_to('Most Popular' ,'@homepage_nav?nav=popular') ?></li>
		<li><?php echo link_to('Last Week' ,'@homepage_nav?nav=lastWeek') ?></li>
		<li><?php echo link_to('Last Month' ,'@homepage_nav?nav=lastMonth') ?></li>
		<li><?php echo link_to('Unanswered' ,'@homepage_nav?nav=unanswered') ?></li>

	</ul>

	</li>

    <?php if(sfConfig::get('app_gear_enable') || myUtil::isGearBeta()): ?>
    <li class="gear"><?php echo link_to('Gear', '@gear') ?>

    <ul>

        <li><?php echo link_to('Browse Gear', '@gear') ?></li>
        <li><?php echo link_to('Gear Companies' ,'@gear_companies') ?></li>
        <li><?php echo link_to('Add Gear' ,'@gear_add_new?add_type=Gear') ?></li>
        <li><?php echo link_to('Add Company' ,'@gear_add_new?add_type=Company') ?></li>

    </ul>

    </li>
    
	<li class="about"><?php echo link_to('About', '@about') ?>
    
    <ul>

        <li><?php echo link_to('F.A.Q.', '@faq') ?></li>
        <li><a href="<?php echo sfConfig::get('app_blog_url') ?>">Blog</a></li>
        <li><?php echo link_to('About' ,'@about') ?></li>

    </ul>

    </li>
    
    <li><?php echo link_to('Users', '@user') ?></li>
	<li><?php echo link_to('Awards', '@awards') ?></li>

    <?php else: ?>

    <li><?php echo link_to('About', '@about') ?></li>
	<li><?php echo link_to('Users', '@user') ?></li>
	<li><?php echo link_to('Awards', '@awards') ?></li>
	<li><?php echo link_to('FAQ', '@faq') ?></li>
    <li><a href="<?php echo sfConfig::get('app_blog_url') ?>">Blog</a></li>

    <?php endif ?>

</ul>
<!-- #nav -->

<?php if(sfContext::getInstance()->getModuleName() != "auth"): ?>
    <?php $session_user = $sf_context->getUser(); ?>

    <?php //if(!$session_user->hasCredential('unconfirmed')): ?>


<ul id="userLog" class="nav bars">


        <?php if($session_user->isAuthenticated() && $session_user->hasCredential('user')): ?>

	        <?php $currentUser = $session_user->getCurrentUser() ?>
	        <?php if($currentUser->getDisplayName()): ?>
	            <?php $userName = $currentUser->getDisplayName() ?>
	        <?php endif; ?>


            <li class="first"><a class="name" href="<?php echo url_for("@profile?display_name=".myUtil::createSlug($currentUser->getDisplayName())."&userId=".$currentUser->getId()) ?>"><?php echo $userName ?></a><span title="Your rank"> (<?php echo $session_user->getUserRank() ?>)</span></li>
            <li><a class="score" href="#" title="Your experience score"><?php echo $currentUser->getExperienceScore() ?></a></li>
            <li><?php echo link_to('(' . UserAwardPeer::getUserAwardCount($currentUser->getId()) . ')', '@awards', array('class' => 'user-win', 'title' => 'Number of awards you have earned')) ?></li>
		    <li><?php echo link_to('Logout', 'auth/logout') ?></li>
	    <?php else: ?>
	       <li>
			
			<?php echo link_to('Login or Sign Up!', '@login', 'class=login') ?>
			</li>
	    <?php endif; ?>

</ul>


	<?php //else: ?>
	<!-- <ul id="userLog" class="nav bars">
	   <li><?php //echo link_to("Registered", "@profile_edit") ?></li>
	</ul> -->
	<?php //endif; ?>
<?php endif; ?></div>

    <div id="feedback">
        <?php echo link_to('Found a Bug?', '@question_detail?question_title=did-you-find-a-bug-or-some-other-problem-with-the-site&question_id=1') ?> |
        <?php echo link_to('Have a suggestion?', '@question_detail?question_title=do-you-have-any-suggestions-or-ideas-that-you-might-like-to-see-added-or-changed&question_id=2') ?>
        <!-- <script type="text/javascript" src="http://cdn.socialtwist.com/2009083124102/script.js"></script><a class="st-taf" href="http://tellafriend.socialtwist.com:80" onclick="return false;" style="border:0;padding:0;margin:0;"><img alt="SocialTwist Tell-a-Friend" style="border:0;padding:0;margin:0;" src="http://images.socialtwist.com/2009083124102/button.png"onmouseout="STTAFFUNC.hideHoverMap(this)" onmouseover="STTAFFUNC.showHoverMap(this, '2009083124102', window.location, document.title)" onclick="STTAFFUNC.cw(this, {id:'2009083124102', link: window.location, title: document.title });"/></a> -->
    </div>

<?php echo notification_display() ?>

<!-- / #header --> <?php echo $sf_content ?></div>
<!-- / #wrap -->

<div id="footer">

<div id="wrapFoot">

<ul class="nav bars">

	<li class="first"><a href="<?php echo url_for('@homepage') ?>">Questions</a></li>
	<li><a href="<?php echo url_for('@ask_question') ?>">Ask Questions</a></li>
	<li><?php echo link_to('Unanswered' ,'@homepage_nav?nav=unanswered') ?></li>
        <li><?php echo link_to('Awards', '@awards') ?></li>
        <li><?php echo link_to('Users', '@user') ?></li>
        <li><a href="<?php echo sfConfig::get('app_blog_url') ?>">Blog</a></li>
        <li><?php echo link_to('Gear', '@gear') ?></li>
        <li><?php echo link_to('Add Gear' ,'@gear_add_new?add_type=Gear') ?></li>
        
	<li><?php echo link_to('F.A.Q.', '@faq') ?></li>
	<li><?php echo link_to('About', '@about') ?></li>
	<li><?php echo link_to('Privacy Policy', '@privacy') ?></li>
	<li><?php echo mail_to('us@recordingquestions.com', 'Contact Us', 'encode=true') ?></li>

</ul>

<div id="twitter">
    <a href="http://twitter.com/recordquestions">Follow us on twitter!</a>
</div>

  <p id="copy">&copy; <?php echo date('Y') ?> Recording Questions <span style="margin:0 5px;">|</span> Created by <a href="http://failpunkmedia.com">Failpunk Media</a></p>

</div>
<!-- #wrapFooter --></div>
<!-- / #footer -->

    <!--[if lte IE 6]>

		<script type="text/javascript" src="/js/dd_pngfix.js"></script>
		<script src="/js/ie6hover.js" type="text/javascript"></script>

	<![endif]-->

<?php if(sfConfig::get('sf_environment') == 'prod'): ?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        try {
        var pageTracker = _gat._getTracker("UA-10119869-1");
        pageTracker._trackPageview();
        } catch(err) {}
    </script>

    <?php include_slot('skimlinks'); ?>
    
    <!-- Start Quantcast tag 
    <script type="text/javascript">
    _qoptions={
    qacct:"p-894UlkOY_g3Bg"
    };
    </script>
    <script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
    <noscript>
    <img src="http://pixel.quantserve.com/pixel/p-894UlkOY_g3Bg.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
    </noscript>
     End Quantcast tag -->
<?php endif ?>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: 'your app id', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>

</body>

</html>
