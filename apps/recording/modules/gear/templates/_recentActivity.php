<div class="blueSidebar recent-activity">

    <h3>Recent Activity</h3>

    <ul>

        <?php foreach($recent_activity as $activity): ?>

        <?php
            $route  = "@profile";
            $route .= "?display_name=" . myUtil::createSlug($activity->getColumn('displayName'));
            $route .= "&userId=" . $activity->getUserId();
        ?>

        <li>

            <?php echo link_to($activity->getColumn('displayName'), $route) ?>

            <span><?php echo date_age_tag($activity->getCreatedAt(), true) ?></span>

            <p>
                <?php if($activity->getActivity() == 'owns'): ?>
                    added the <?php echo html_entity_decode($activity->createPageLink()) ?> to their studio
                <?php elseif($activity->getActivity() == 'user review' || $activity->getActivity() == 'review link'): ?>
                    added a <?php echo $activity->getActivity() ?> for the <?php echo html_entity_decode($activity->createPageLink()) ?>
                <?php else: ?>
                    <?php echo $activity->getActivity() ?> the <?php echo html_entity_decode($activity->createPageLink()) ?> page
                <?php endif ?>
            </p>

        </li>
        <?php endforeach ?>

    </ul>

    <p class="right">
        <?php echo link_to('View More Recent Activity &raquo', '@gear_rencent_activity') ?>
    </p>

</div><!-- #recentUsers -->