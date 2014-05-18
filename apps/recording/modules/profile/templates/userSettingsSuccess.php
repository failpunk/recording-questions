<?php use_helper('Form', 'jQuery', 'custom'); ?>

<div id="content">

    <div id="main">

        <h1 class="title"><strong>Settings for <?php echo ucfirst($user->getDisplayName()) ?></strong></h1>

        <!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

        <p class="p2">Use this section to control some of the basic site settings.</p>

        <?php include_partial('userTabs', array(
                                        'user' => $user,
                                        'currentPage' => $currentPage,
                                        'maxResultsPerPage' => $maxResultsPerPage
                                     )) ?>

        <?php echo form_tag('@profile_save_settings?userid='.$user->getId(), array("method" => "post", "class" => "set-account")) ?>

        <ol class="fieldset">

             <li class="field">

                <h4>Use a Different OpenID Login</h4>

                <p class="p4">If you would like to use a different login for your current account, please click the link below and sign in as you normally would.</p>

                <h4><a href="<?php echo url_for('@change_account') ?>">Add a Different Login to Your Account</a></h4><br>

            </li>

            <?php echo jq_form_remote_tag(
                array(
                                             'update'   => 'positiveTags',
                                             'url'      => 'profile/addTags',
                ),
                array(
                                             'class' => 'set-account'
                )
            ) ?>
            <li class="field first">

                <h4>Favourite Tags</h4>

                <?php echo jq_input_auto_complete_tag('positiveTagsAutocom', '',
                                                'profile/autocomplitTags',
                    array(
                                                     'autocomplete' => 'off',
                                                     'type' => 'text',
                                                     'class' => 'text'
                    ),
                    array(
                                                         'use_style'         => true,
                                                         'multipleSeparator' => ' ',
                                                         'multiple'          => true
                    )
                ) ?>
                <?php echo input_hidden_tag("act", 'positive') ?>
                <?php echo submit_tag('Add Tag', array('class' => 'submit')) ?>

                <p class="txt01">Add the tags separatted by commas (,)</p>

                <h5>Current selected tags</h5>

                <ul class="tags2 clearfix" id="positiveTags">
                    <?php foreach ($userPositiveTags as $userPositiveTag): ?>
                    <li><span class="delete">
                            <?php echo jq_link_to_remote('delete', array(
                                                            'update' => 'positiveTags',
                                                            'url'    => 'profile/deleteTag?tagId='.$userPositiveTag->getTag()->getId().'&act=positive',
                                )) ?>
                    </span><a href="#"><?php echo $userPositiveTag->getTag()->getName() ?></a></li>


                    <?php endforeach; ?>
                </ul>

                <p class="txt01">Click on the tag to remove</p>

            </li>
            </form>
            <?php echo jq_form_remote_tag(
                array(
                                                         'update'   => 'negativeTags',
                                                         'url'      => 'profile/addTags',
                ),
                array(
                                                         'class' => 'set-account'
                )
            ) ?>
            <li class="field">

                <h4>Ignored Tags</h4>

                <?php echo jq_input_auto_complete_tag('negativeTagsAutocom', '',
                                                'profile/autocomplitTags',
                    array(
                                                     'autocomplete' => 'on',
                                                     'type' => 'text',
                                                     'class' => 'text'
                    ),
                    array(
                                                         'use_style'         => true,
                                                         'multipleSeparator' => ' ',
                                                         'multiple'          => true
                    )
                ) ?>
                <?php echo input_hidden_tag("act", 'negative') ?>
                <?php echo submit_tag('Add Tag', array('class' => 'submit')) ?>

                <p class="txt01">Add the tags separatted by commas (,)</p>

                <h5>Current selected tags</h5>

                <ul class="tags2 clearfix" id="negativeTags">
                    <?php foreach ($userNegativeTags as $userNegativeTag): ?>
                    <li><span class="delete">
                            <?php echo jq_link_to_remote('delete', array(
                                                            'update' => 'negativeTags',
                                                            'url'    => 'profile/deleteTag?tagId='.$userNegativeTag->getTag()->getId().'&act=negative',
                                )) ?>
                    </span><a href="#"><?php echo $userNegativeTag->getTag()->getName() ?></a></li>
                    <?php endforeach; ?>
                </ul>

                <p class="txt01">Click on the tag to remove</p>

            </li>
            </form>
            <li class="field">

                <h4>Other Settings</h4>

                <p class="checkbox">
                
                    <?php echo checkbox_tag('emailnotify', $notify, ($notify) ? true : false) ?>
                    <label>I'd like email notifications of activity on my questions and answers when I've been away for more than 7 days</label>

                </p>

            </li>

            <p class="ask-your-question">

                <input type="submit" value="Save Settings" class="submit"/>

            </p>

        </ol>

        </form>

    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

        <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->