<?php use_helper('Form'); ?>

<div id="content">

    <div id="main">

        <?php if ($sf_user->hasFlash('authError')): ?>
            <div id="alertTop" class="popup three left" style="margin-bottom: 20px;">

                <p style="margin-bottom:10px;"><?php echo $sf_user->getFlash('authError') ?>.</p>

                <p class="close"><a href="#">X</a></p>

            </div><!-- .popup -->
        <?php endif ?>

        <h3>Change Your OpenID Login</h3>

        <h4>You can use this page to use a different OpenID login</h4><br/>

        <p>From time to time people want to change their account login from one provider to another. (For example you may want to change your login from Google to Facebook)</p>

        <p>Simply use the login box below to sign in with your new provider.  You will then be able to use both the new and the old provider to log into your account.</p>

        <p>If you have any other problems with your account login, please email us at <?php echo mail_to('us@recordingquestions.com', 'us@recordingquestions.com', 'encode=true') ?></p>

        <div id="login-box">
            <iframe src="https://<?php echo sfConfig::get('app_rpx_auth_domain'); ?>/openid/embed?token_url=http://<?php echo sfConfig::get('app_change_account_token'); ?>"
              scrolling="no" frameBorder="no" style="width:320px;height:240px;">
            </iframe>
        </div>

    </div><!-- / #main -->

    <div id="sidebar">

        <div class="wrap-box">

            <div class="box first">

                <h3>Why Use OpenID?</h3>

                <p>Why should you have a different user name and password for every site?</p>

                <p>OpenID provides the ability to use a single username and password for any OpenID enabled site.</p>

                <p>This system makes it easy to sign-in and keep your personal data safe.</p>

                <p class="see"><a href="http://openid.net/what/" target="_blank">Learn more about OpenID</a></p>

            </div><!-- .box -->

            <div class="box">

                <h3>Who Uses OpenID?</h3>

                <p>Here are some other sites that are also using OpenID authentication.</p>
                <p>

                    <code>

                        Google<br />
                        Facebook<br />
                        Yahoo<br />
                        Universal Music<br />
                        Twitter

                    </code>

                </p>

            </div><!-- .box -->

        </div><!-- .wrap-box -->

    </div><!-- / #sidebar -->

</div><!-- / #content -->