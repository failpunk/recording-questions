<div id="alertTop" class="popup three left" style="margin: 0;">

    <h4>This question is currently Locked!</h4>

    <p style="margin-bottom:10px;">
        This question has been locked because we believe <?php echo $reason_type ?>.
        <?php if($duplicate): ?>
            You can find a link to the original question below.
        <?php endif ?>
    </p>

    <?php if($duplicate): ?>
        <h4><a style="font-size:.85em;" href="<?php echo url_for('@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId()) ?>"><?php echo $question->getTitle() ?></a></h4>
    <?php endif ?>

    <p>As always, if you think this is incorrect in some way please email us at: us@recordingquestions.com</p>

</div><!-- .popup -->

<div style="clear: both;"></div>