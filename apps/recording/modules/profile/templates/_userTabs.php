<?php use_helper('custom'); ?>

<div class="head-tabs">

    <ul class="nav">

        <li><?php echo link_to_active("User's Bio", "@profile?display_name=".myUtil::createSlug($user->getDisplayName())."&userId=".$user->getId(),'active') ?></li>
        
        <li><?php echo link_to_active("User's Statistics", "@profile_stats?display_name=".myUtil::createSlug($user->getDisplayName())."&userId=".$user->getId(),'active') ?></li>

        <!--<li><?php echo link_to_active("Recent Activity", "@profile_recent?display_name=".myUtil::createSlug($user->getDisplayName())."&userId=".$user->getId(),'active') ?></li>-->

        <li><?php echo link_to_active("Favorite Questions", '@profile_favorite_nav_pager?display_name='.myUtil::createSlug($user->getDisplayName()).'&currentPage='.$currentPage.'&maxResultsPerPage='.$maxResultsPerPage.'&userId='.$user->getId(),'active') ?></li>

        <?php if($sf_context->getUser()->isAuthenticated() && $sf_context->getUser()->getCurrentUser()->getId() == $user->getId()): ?>
            <?php $referrals = MemberReferralPeer::getReferralCount($user->getId()) ?>
            <li><?php echo link_to_active("Refer a Friend ($referrals)", "@profile_refer_a_friend?display_name=".myUtil::createSlug($user->getDisplayName())."&userId=".$user->getId(),'active') ?></li>

            <li><?php echo link_to_active("Settings", '@profile_settings', 'active') ?></li>
        <?php endif; ?>

    </ul>

</div><!-- .head-tabs -->