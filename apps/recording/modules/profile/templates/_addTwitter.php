<?php if($sf_user->isAuthenticated() && $user->getId() == $sf_user->getCurrentUser()->getId()): ?>

    <script type="text/javascript">

        $().ready(function()
        {
            // remove directions from search box
            $('input.twitter-account').focus(function()
            {
                if($(this).val() == "Your Twitter name" || $(this).val() == "Your Twitter password") {
                    $(this).val("");
                }
            });

            // remove directions from search box
            $('input.twitter-account').blur(function()
            {
                if($(this).val() == "" && $(this).attr('id') == "twittername") {
                    $(this).val("Your Twitter name");
                }

                if($(this).val() == "" && $(this).attr('id') == "twitterpass") {
                    $(this).val("Your Twitter password");
                }
            });

        });

    </script>

    <div class="wrap-box">

        <div id="add-twitter-account" class="box first">

            <span class="add-twitter-bg"></span>

            <h3>Twitter Updates</h3>

            <p class="twitter-info">Add twitter updates to your Recording Questions profile.  We'll share your recording question updates on Twitter for you!</p>

            <?php if($twitter->getUserName()): ?>

                <p>
                    <strong>@<?php echo $twitter->getUserName() ?></strong>
                    (<a id="change-twitter-account" href="#" style="font-size:11px;">change</a>)
                </p>

                <p>
                    Status updates are <strong><?php echo ($twitter->isActive()) ? 'on' : 'off' ?></strong>
                    (<a id="change-twitter-status" href="#" style="font-size:11px;">turn <?php echo ($twitter->isActive()) ? 'off' : 'on' ?></a>)
                </p>

                <p>
                    <span>Tweet about <?php echo ($twitter->getType() == 'all') ? 'questions and gear' : 'questions' ?></span>
                    (<a id="change-twitter-type" href="#" style="font-size:11px;">change</a>)
                </p>

            <?php endif ?>

            <div class="twitter-info" style="display:<?php echo $edit_account ?>;">

                <ul class="inputbox">

                    <li>

                       <input type="text" name="twittername" value="Your Twitter name" class="text ac_input twitter-account" id="twittername"/>

                    </li>

                    <li>

                       <input type="password" name="twitterpass" value="Your Twitter password" class="text ac_input twitter-account" id="twitterpass"/>

                    </li>

                </ul>

                <p class="right">
                    <a id="submit-twitter-link" href="#">Add My Twitter Account! »</a>
                </p>

                <div class="messageBox one" style="display:none;">
                    <p style="margin-bottom: 10px;">We were unable to verify your twitter account.  Can you please double check your user name and password.</p>
                </div>

            </div>

            <div class="messageBox two confirmation" style="display:none;">
                <p style="margin-bottom: 10px;">Awesome!  Your Twitter account has been added.  Now, go record something!</p>
            </div>

            <?php echo input_hidden_tag('submit-twitter-route', url_for('@add_twitter_credientials')); ?>
            <?php echo input_hidden_tag('change-twitter-status-route', url_for('@toggle_twitter_status')); ?>
            <?php echo input_hidden_tag('change-twitter-type-route', url_for('@toggle_twitter_type')); ?>

        </div><!-- .box -->

    </div>

<?php endif ?>