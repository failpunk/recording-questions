<?php use_helper('jQuery', 'tooltips'); ?>

<?php
    $vote_type = '';

    if(isset($vote) && $vote)
        $vote_type = 'add';

    if(isset($vote) && !$vote) 
        $vote_type = 'sub';
    
    if( isset($answerVote[$answer->getId()]) )
    {
        if($answerVote[$answer->getId()]->getPositive())
            $preVote = true;

        if($answerVote[$answer->getId()]->getNegative())
            $preVote = false;
    }
?>

<p class="votes <?php echo $vote_type ?>">

    <span class="sub">
        <?php echo jq_link_to_remote('-',
          array(
            'update' => "answerNum".$answer->getId(),
            'url'    => '@question_detail_vote_for_answer?answer_id='.$answer->getId().'&vote=sub'
          ),
          array(
            'title'  => 'This is a poor answer?(click again to undo)',
            'class'  => isset($vote) ? ( ( isset($vote) && $vote ) ? '' : 'vote') : '',
          ))
        ?>
    </span>

    <span class="num"><?php echo $countVote ?></span>

    <?php $countVote = $answer->getTotalVotes() ?>

    <span class="add">
        <?php echo jq_link_to_remote('+',
          array(
            'update' => "answerNum".$answer->getId(),
            'url'    => '@question_detail_vote_for_answer?answer_id='.$answer->getId().'&vote=add'
          ),
          array(
            'title'  => 'This is a good answer?(click again to undo)',
             'class'  => ((isset($vote) && $vote) ? 'vote' : '')
          ))
        ?>
    </span>

</p>

<?php unset($preVote) ?>

<?php $voteForTooltips = isset($is_old) ? 'old' : $voteForTooltips ?>

<?php if($sf_user->hasCredential('vote-spamer')): ?>
    <?php $voteForTooltips = 'too_many' ?>
<?php endif; ?>

<?php echo dispalay_tooltip("AnswerVote", $answer->getId(), $voteForTooltips);  ?>