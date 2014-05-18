<?php use_helper('Form', 'jQuery'); ?>

<div id="questionComments<?php echo $questionId ?>">

    <?php echo include_partial('question/comments', array(
            'type'          => 'question',
            'id'            => $questionId,
            'comments'      => $comments,
        )
    ) ?>

    <?php echo jq_link_to_remote('Add a Comment',
        array(
                'update'   => 'add_question_comment_'.$questionId,
                'url'      => 'question/addQuestionComment?question_id='.$questionId,
                'position' => 'bottom'
             ),
        array(
                'class' => 'add-comment'
             )
    ) ?>
    
</div>

<div id="add_question_comment_<?php echo $questionId ?>"></div>