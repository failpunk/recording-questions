<?php use_helper('jQuery', 'tooltips'); ?>

<?php
    $vote_type = '';

    if(isset($vote) && $vote) {
        $vote_type = 'add';
    }
    
    if(isset($vote) && !$vote) {
        $vote_type = 'sub';
    }
?>

<p class="votes <?php echo $vote_type ?>">

    <span class="sub">
         <?php echo jq_link_to_remote('-',
             array(
                'update' => "num".$question->getId(),
                'url'    => '@question_detail_vote_for_question?question_id='.$question->getId().'&vote=sub'
             ),
             array(
                'class'  => isset($vote) ? ( ( isset($vote) && $vote ) ? '' : 'vote') : '',
                'title'  => 'This is a poor answer?(click again to undo)'
             ))
         ?>
    </span>

    <span class="num" ><?php echo $countVote ?></span>

    <span class="add">
        <?php echo jq_link_to_remote('+',
            array(
                'update' => "num".$question->getId(),
                'url'    => '@question_detail_vote_for_question?question_id='.$question->getId().'&vote=add'
            ),
            array(
                'title'  => 'This is a good answer?(click again to undo)',
                'class'  => ((isset($vote) && $vote) ? 'vote' : '')
            ))
        ?>
    </span>

</p>

<?php $voteForTooltips = isset($is_old) ? 'old' : $voteForTooltips ?>

<?php if($sf_user->hasCredential('vote-spamer')): ?>
    <?php $voteForTooltips = 'too_many' ?>
<?php endif; ?>

<?php echo dispalay_tooltip("QuestionVote", $question->getId(), $voteForTooltips);  ?>
