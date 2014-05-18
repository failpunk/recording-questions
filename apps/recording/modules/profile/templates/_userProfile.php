<?php use_helper('Gravatar'); ?>

<div id="about">

    <h3><?php echo $currentUser->getDisplayName() ?></h3>

    <div id="stats">

        <p class="avatar1"><?php echo gravatar_image_tag($currentUser->getEmail())?></p>

        <ul class="list-score">

            <li class="first"><span class="experience">Score: <span class="score"><?php echo $currentUser->getExperienceScore() ?></span></span></li>
            <li>Rank: <a href="#" title="Where your experience score ranks among other users">#<?php echo $userRank ?></a></li>
            <li>Awards: <span class="user-win" title="Number of awards you have earned"><?php echo link_to('(' . UserAwardPeer::getUserAwardCount($currentUser->getId()) . ')', '@awards') ?></span></li>

        </ul>

    </div><!-- #stats -->

    <ul>

        <li class="first" id="realName">Real Name: <span class="color1"><?php echo $currentUser->getRealName() ?></span></li>

        <li class="first" id="realName">Profile Views: <span class="color1"><?php echo $profile_views ?></span></li>

    </ul>

    <?php if($sf_context->getUser()->getCurrentUser()->getId() == $currentUser->getId()): ?>
        <p class="align-r"><?php echo link_to("Edit Account Details", "@profile_edit", array('rel' => 'nofollow')) ?></p>
    <?php endif ?>

</div><!-- #about -->