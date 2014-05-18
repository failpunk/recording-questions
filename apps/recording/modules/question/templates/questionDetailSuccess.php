<?php use_helper('Form', 'custom', 'Gravatar', 'jQuery', 'Validation'); ?>

<?php // Canonical Tag ?>
<?php if(!is_null($nav)): ?>
    <?php echo add_link(Question::constructQuestionRoute($question->getTitle(), $question->getId()), 'canonical') ?>
<?php endif ?>

<?php // add skimlinks js code on only questions ?>
<?php //echo add_skimlinks() ?>

<script type="text/javascript">

    $().ready(function()
    {
        <?php if($sf_user->getFlash('answerQuestionError')): ?>
            window.location.hash = '#answer-form';
        <?php endif ?>
        // Highlight owner - questionDetail.js
        HighlightUserPosts('<?php echo $question->getUser()->getDisplayName() ?>', '#EFF6F9');

    });

</script>

<?php
if(isset($userFavorite))
    $status = '';
else
    $status = "2";
 ?>
<?php $question = $sf_data->getRaw('question'); ?>
<?php $bestAnswer = false ?>
<?php $session_user = $sf_context->getUser(); ?>

<div id="content">
  
   <?php echo include_component('question', 
                                'topAdminControls',
                                array(
                                    'ownQuestion' => $ownQuestion,
                                    'question' => $question
                                )) ?>

    <div id="main">

        <?php echo include_partial('question',
                        array(
                                'question' => $question,
                                'status' => $status,
                                'user' => $user,
                                'vote_type' => $vote_type,
                                'questionComments' => $questionComments,
                                'vote' => isset($vote) ? $vote : null
                        )
        ) ?>

        <div class="head-tabs">

            <h3><?php echo count($answers) ?> Answers</h3>

            <ul class="nav">
               <?php if(!isset($nav)): ?>
                   <li><?php echo link_to_active('Votes' ,'@question_detail_nav?question_id='.$question->getId().'&nav=votes','active', true,'Sort answers by number of votes') ?></li>
               <?php else: ?>
                   <li><?php echo link_to_active('Votes' ,'@question_detail_nav?question_id='.$question->getId().'&nav=votes','active', '','Sort answers by number of votes') ?></li>
               <?php endif; ?>
                <li><?php echo link_to_active('Oldest' ,'@question_detail_nav?question_id='.$question->getId().'&nav=oldest','active', '','Sort answers in chronological order') ?></li>
                <li><?php echo link_to_active('Newest' ,'@question_detail_nav?question_id='.$question->getId().'&nav=newest','active', '','Sort answers with newest first') ?></li>
            </ul>

        </div><!-- .head-tabs -->

        <?php echo include_partial('answers',
                        array(
                                'question' => $question,
                                'sf_data' => $sf_data,
                                'user_question' => $user_question
                        )
        ) ?>

    <?php echo include_partial('answerForm', array(
                    'question' => $question
                  )
    ) ?>

    <div class="other-questions">

        <p>Not the answers you're looking for? <a href="<?php echo url_for('@ask_question') ?>">Try asking your own question.</a></p>
    <!--
        <ul class="tags">

            <li><a href="#">theory</a></li>
            <li><a href="#">sinthesizers</a></li>
            <li><a href="#">software</a></li>
            <li><a href="#">cables</a></li>
            <li><a href="#">instruments</a></li>
            <li><a href="#">rythm box</a></li>

        </ul>

        <p><a href="<?php echo url_for('@ask_question') ?>">Try asking your own question.</a></p>

    -->

    </div>

</div><!-- / #main -->

<div id="sidebar">

    <?php include_component('index', 'recentAnswers') ?>

    <?php include_component('gear', 'recentActivity') ?>

    <?php include_component('user', 'recentUsers') ?>

    <?php include_component('index', 'tagCloud') ?>

</div><!-- / #sidebar -->

</div><!-- / #content -->