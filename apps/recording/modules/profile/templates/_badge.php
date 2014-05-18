<?php if($sf_user->isAuthenticated() && $user->getId() == $sf_user->getCurrentUser()->getId()): ?>

    <div class="wrap-box">

        <div id="add-twitter-account" class="box first">

            <h3>Link To Your Profile</h3>

            <p class="twitter-info">Now you can link back to your Recording Questions profile page from your own website or blog.</p>

            <p>
                <center>
                    <iframe width="112" height="93" frameborder="0" scrolling="no" src="<?php echo url_for('@get_badge?user_id='.$user->getId().'&type=default&get_badge=true', true) ?>" marginheight="0" marginwidth="0"></iframe>
                </center>
            </p>

            <p class="right" style="padding-top: 15px;">
                <?php echo link_to('Go Get Your Badge »', '@profile_badge_page') ?>
            </p>

        </div><!-- .box -->

    </div>

<?php endif ?>