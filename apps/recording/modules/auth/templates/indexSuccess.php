<?php use_helper('Form'); ?>

<div id="content">

    <div id="main">

        <?php if ($sf_user->hasFlash('guest_asking_questionsdf')): ?>
            <div id="alertTop" class="popup three left" style="margin-bottom: 20px;">

                <h4>That's Great...you want to ask a question!</h4>

                <p style="margin-bottom:10px;">In order for us to keep all your questions organized, we need you to take a moment and let us know who you are.  The link below will bring you to the super-easy sign up page.</p>
                <h4><a href="<?php echo url_for('@login') ?>">Sign In or Sign Up</a></h4>

                <p class="close"><a href="#">X</a></p>

            </div><!-- .popup -->
        <?php endif ?>

        <h3>Login or Signup with OpenID</h3>

        <h4>With OpenID, we use your existing account at any of the following sites to login to Recording Questions. -- Simply click on the account you would like to use...</h4><br/>

        <div id="login-box">
            <iframe src="https://<?php echo sfConfig::get('app_rpx_auth_domain'); ?>/openid/embed?token_url=http://<?php echo sfConfig::get('app_rpx_auth_token'); ?>"
              scrolling="no" frameBorder="no" style="width:375px;height:240px;">
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