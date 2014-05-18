<div id="recentUsers">

    <h3>Newest Members</h3>

    <ul>

        <?php foreach($users as $user): ?>
        <li>

            <?php echo link_to($user->getDisplayName(), "@authorProfile?userId=".$user->getId()) ?>
            <?php if($user->getCountry()): ?>
                <?php echo image_tag("flags/" . Flag::getFlagByCounty($user->getCountry()), array('title' => strtolower($user->getCountry()))) ?>
            <?php endif ?>
            <span class="score"><span title="This users current experience point total">(<?php echo $user->getExperienceScore() ?>)</span></span>

        </li>
        <?php endforeach ?>
        
    </ul>

    <p class="right"><?php echo link_to('Find a Member &raquo', '@user') ?></p>

</div><!-- #recentUsers -->