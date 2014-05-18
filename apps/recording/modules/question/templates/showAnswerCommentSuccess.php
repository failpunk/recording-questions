<?php use_helper('Form', 'jQuery'); ?>

<div id="answerComments<?php echo $answerId ?>">

    <?php if($status == "close"): ?>

        <?php echo include_partial('question/comments', array(
                'type'          => 'answer',
                'id'            => $answerId,
                'comments'      => $comments,
                'questionId'    => $questionId
            )
        ) ?>

    <?php else: ?>

        <?php echo include_partial('question/comments', array(
                'type'          => 'answer',
                'id'            => $answerId,
                'comments'      => $comments,
                'limitComment'  => true,
                'questionId'    => $questionId
            )
        ) ?>

    <?php endif; ?>

    <?php echo jq_link_to_remote('Add a Comment',
        array(
                'update' => 'add_comment_'.$answerId,
                'url'    => 'question/addComment?answer_id='.$answerId.'&question_id='.$questionId,
                'position' => 'bottom'
             ),
        array(
                'class' => 'add-comment'
             )
    ) ?>

</div>

<div id="add_comment_<?php echo $answerId ?>"></div>