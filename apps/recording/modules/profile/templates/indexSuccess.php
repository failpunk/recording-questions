<?php use_helper('Form', 'jQuery', 'custom'); ?>

<div id="content">

    <div id="main">

        <h1 class="title"><strong>Profile for <?php echo ucfirst($user->getDisplayName()) ?></strong></h1>

        <!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

        <?php include_partial('userTabs', array(
                                'user' => $user,
                                'currentPage' => $currentPage,
                                'maxResultsPerPage' => $maxResultsPerPage
                             )) ?>

        <?php if(isset($percent_complete) && $user->getId() == $sf_context->getUser()->getCurrentUser()->getId()): ?>
            <div class="box-preview profile-completed">
                <p><strong>You profile is <?php echo $percent_complete ?>% complete.</strong> <?php echo link_to("Complete your profile", "@profile_edit", array('rel' => 'nofollow')) ?> and earn the <em>published member award</em>.</p>
            </div>
        <?php endif ?>

        <ul class="list-stats">
        
            <li>

                <p class="date1">Real Name:</p>

                <p>
                    <?php echo $user->getDisplayName() ?>&nbsp;
                </p>

            </li>
        
            <li>

                <p class="date1">Website:</p>

                <p>
                    <a href="<?php echo $user->getWebpage() ?>" rel="nofollow"><?php echo $user->getWebpage() ?></a>&nbsp;
                </p>

            </li>

            <li>

                <p class="date1">Bio:</p>

                <p>
                    <?php echo html_entity_decode($info) ?>&nbsp;
                </p>

            </li>
            
            <li>

                <p class="date1">Location:</p>

                <p>
                    <?php echo $user->getLocation() ?>&nbsp;
                </p>

            </li>

            <li>

                <p class="date1">Country:</p>

                <p>
                    <?php echo ucwords(strtolower($user->getCountry())) ?>&nbsp;
                    <?php if($user->getCountry()): ?>
                        <?php echo image_tag("flags/" . Flag::getFlagByCounty($user->getCountry())) ?>
                    <?php endif ?>
                </p>

            </li>

            <li>

                <p class="date1">Age:</p>

                <p>
                    <?php echo myUtil::nicetime($user->getBirthday()) ?>&nbsp;
                </p>

            </li>
            
        </ul>

        <?php if(sfConfig::get('app_gear_enable') || myUtil::isGearBeta()): ?>
            <?php include_component('gear', 'userStudio', array('user_id' => $user->getId())) ?>
        <?php endif ?>

    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>
        
        <?php include_partial('profile/badge', array('user' => $user)) ?>
        
        <?php include_component('profile', 'addTwitter', array('user' => $user)) ?>

        <?php include_partial('profile/studioImage', array('user' => $user)) ?>

        <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->