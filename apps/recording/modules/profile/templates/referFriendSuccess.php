<?php use_helper('Form', 'jQuery', 'custom'); ?>

<script type="text/javascript">

    $(document).ready(function() {

        $("#email1").focus();
        $("#email1").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email1'); } });
        $("#email2").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email2'); } });
        $("#email3").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email3'); } });
        $("#email4").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email4'); } });
        $("#email5").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email5'); } });
        $("#email6").typeWatch({ highlight: true, wait: 750, captureLength: 5, callback: function() { filter('email6'); } });

        function filter(text)
        {
            var element = $('#'+text);
            $.post
            (
                '<?php echo url_for('@email_referral_check') ?>',
                { email: element.val() },
                function(result) {
                      displayEmailCheck(result, element);
                },
                "json"
            );
        }

        function displayEmailCheck(data, element)
        {
            if(data.found) {
                $(element).css('color', 'red');
                $("#email-error").show();
            } else {
                $(element).css('color', 'green');
                $("#email-error").hide();
            }
        }

    });

</script>


<div id="content">

    <div id="main">

        <h1 class="title"><strong>Refer a Friend, Win a Shirt</strong></h1>

        <!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

        <p class="p2">Qualify to be entered into our weekly t-shirt drawing by referring friends to Recording Questions.</p>

        <?php include_partial('userTabs', array(
                                        'user' => $user,
                                        'currentPage' => $currentPage,
                                        'maxResultsPerPage' => $maxResultsPerPage
                                     )) ?>

        <?php if($sf_user->hasFlash('referral_sent')): ?>
            <p class="notify-element">
                Thanks for helping to spread the word about Recording Questions!  We really appreciate it.<br/>
                Check back soon to see if you won a t-shirt.
            </p>
        <?php endif ?>

         <ul class="list-stats" style="">

            <li>

                <p class="date1">Referral Stats:</p>

                <p>
                    <span class="point1" title="Contest Points">
                        <strong><?php echo $points ?></strong> referral points earned
                        <span>(1 point for each email sent)</span>
                    </span>
                </p>

                <p>
                    <span class="point1" title="Contest Points">
                        <?php if($contests > 0): ?>
                            You are eligible for the next <strong><?php echo $contests ?></strong> drawings
                        <?php else: ?>
                            Send <strong><?php echo $emails_for_next_entry ?></strong> emails to be entered into the next drawing
                        <?php endif ?>
                    </span>
                </p>

                <p>
                    <span class="point1" title="New Members">
                        <strong><?php echo $referrals ?></strong> friends have become members
                        <?php if($members_remaining > 0): ?>
                            <span>(recruit <?php echo $members_remaining ?> more friends to receive a free shirt)</span>
                        <?php else: ?>
                            <span>(congrats...you've won a Recording Questions t-shirt)</span>
                        <?php endif ?>
                    </span>
                </p>

            </li>

        </ul>

        <?php echo form_tag('@profile_send_referral?userId='.$user->getId(), array("method" => "post", "class" => "set-account")) ?>

            <ol class="fieldset">

                <li class="field first">
                    <h4>Start Sending Referrals</h4>
                    <?php echo input_tag("from", $user->getDisplayName(), array('class' => 'text')) ?>
                    <p class="txt01">Enter the name you would like the email to be from</p>
                </li>

                <li class="field first">
                    <h5 id="emails-header">Friends Email Addresses</h5>
                    <?php echo input_tag("email1", '', array('class' => 'text emails')) ?>
                    <?php echo input_tag("email2", '', array('class' => 'text emails')) ?>
                    <?php echo input_tag("email3", '', array('class' => 'text emails')) ?>
                    <?php echo input_tag("email4", '', array('class' => 'text emails')) ?>
                    <?php echo input_tag("email5", '', array('class' => 'text emails')) ?>
                    <?php echo input_tag("email6", '', array('class' => 'text emails')) ?>
                    <p id="email-error" class="txt01" style="color:red; display:none;">This email is either already a member or you have already sent them an invite.</p>
                    <p class="txt01">Enter the email addresses of those you would like to send an invite to</p>
                </li>

                <li>
                    <h5>Invite message</h5>
                    <?php echo textarea_tag('invite', $invite_message, array('class' => 'textarea resizable processed')) ?>
                    <p class="txt01">This message will be sent to the email addresses above</p>
                </li>

            </ol>

            <p class="submit">
                <input type="submit" class="submit" value="Send Referrals" />
            </p>

        </form>

    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

        <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->