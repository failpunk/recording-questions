<?php use_helper('Form', 'jQuery', 'custom', 'Gravatar'); ?>

<div id="content">

    <div id="main">

        <h1 class="title"><strong>Get Your Own Badge</strong></h1>

        <p class="p4">Add your own personal badge to a website or a blog and let everyone know about your profile on Recording Questions.  Here are the badges available to you:</p>

        <div style="margin-bottom: 2em; padding: 0 50px;">

            <iframe width="112" height="93" frameborder="0" scrolling="no" src="<?php echo url_for('@get_badge?user_id='.$user->getId().'&type=default', true) ?>" marginheight="0" marginwidth="0"></iframe>

            <div style="background-color: black; width: 115px; float:right; margin-right: 50px;">
                <iframe width="112" height="93" frameborder="0" scrolling="no" src="<?php echo url_for('@get_badge?user_id='.$user->getId().'&type=white', true) ?>" marginheight="0" marginwidth="0"></iframe>
            </div>

            <p style="padding-top: 10px;">
                <span style="margin-left:25px;">Blue Badge</span>
                <span style="margin-left:306px;">White Badge</span>
            </p>

        </div>

        <div class="box-preview">

            <p><strong>How to add a badge to your website or blog</strong></p>

            <p>You need at least basic access to your sites HTML files to be able to add your badge, but we're going to try and keep it as simple as possible.  First, copy the code for the badge you would like to display below, then paste it into the code on your own site or blog where you would like to display it.  That's it!</p>
            <br>

            <strong>Blue Badge</strong>
            <blockquote style="background-color: #DBEFB3; padding: 10px;">
                <?php echo htmlentities('<iframe width="112" height="93" frameborder="0" scrolling="no" src="'.url_for('@get_badge?user_id='.$user->getId().'&type=default', true).'" marginheight="0" marginwidth="0"></iframe>') ?>
            </blockquote><br><br>

            <strong>White Badge</strong>
            <blockquote style="background-color: #DBEFB3; padding: 10px;">
                <?php echo htmlentities('<iframe width="112" height="93" frameborder="0" scrolling="no" src="'.url_for('@get_badge?user_id='.$user->getId().'&type=white', true).'" marginheight="0" marginwidth="0"></iframe>') ?>
            </blockquote>

                

        </div>

    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>
        
        <?php include_component('profile', 'addTwitter', array('user' => $user)) ?>
        
        <?php include_partial('profile/studioImage', array('user' => $user)) ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->