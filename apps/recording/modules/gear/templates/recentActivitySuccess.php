<?php use_helper('Gravatar', 'custom') ?>

<div id="content">

    <div id="main">

        <h1 class="title">Recent Member Activity</h1>

        <div class="info">

            <p class="dates">

                <a href="#">Gear</a> >
                Browse

            </p>

        </div><!-- .info -->

        
        <ol id="searchResults" class="activity-list">

            <?php foreach($recent_activity->getResults() as $activity): ?>

            <?php
                $route  = "@profile";
                $route .= "?display_name=" . myUtil::createSlug($activity->getColumn('displayName'));
                $route .= "&userId=" . $activity->getUserId();
            ?>
            <li>

                <h4><?php echo link_to($activity->getColumn('displayName'), $route) ?></h4>

                <p class="avatar"><?php echo gravatar_image_tag($activity->getColumn('email'))?></p>

                <p>
                    <?php if($activity->getActivity() == 'owns'): ?>
                        added the <?php echo html_entity_decode($activity->createPageLink()) ?> to their studio
                    <?php elseif($activity->getActivity() == 'user review' || $activity->getActivity() == 'review link'): ?>
                        added a <?php echo $activity->getActivity() ?> for the <?php echo html_entity_decode($activity->createPageLink()) ?>
                    <?php else: ?>
                        <?php echo $activity->getActivity() ?> the <?php echo html_entity_decode($activity->createPageLink()) ?> page
                    <?php endif ?>
                    <span><?php echo date_age_tag($activity->getCreatedAt()) ?></span>
                </p>

            </li>
            <?php endforeach ?>

        </ol>

        <?php include_component('index', 'pagination', array('pager' => $recent_activity, 'route' => 'gear_rencent_activity')) ?>

    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('index', 'recentAnswers') ?>

        <?php include_component('gear', 'companies') ?>

        <?php include_partial('index/googleAds') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_component('index', 'tshirts') ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->