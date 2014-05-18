<?php use_helper('Gravatar'); ?>
<?php echo stylesheet_tag('badge') ?>

<div class="recording-questions-badge <?php echo $type ?>">

    <?php if($get_badge): ?>
        <a title="RecordingQuestions.com - An Audio Recording Community" href="<?php echo url_for('@profile_badge_page', true) ?>" target="_blank">
    <?php else: ?>
        <a title="RecordingQuestions.com - An Audio Recording Community" href="<?php echo url_for(html_entity_decode($user->getRoute()), true) ?>" target="_blank">
    <?php endif ?>
        <p title="Recording Questions Experience Score" class="experience-score"><?php echo $user->getExperienceScore() ?></p>

        <?php echo image_tag($image) ?>

    </a>

</div>