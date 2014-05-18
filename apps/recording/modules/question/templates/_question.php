<?php
/* 
 * Displays the Question of the question detail page
*/
?>

<h1 class="question"><?php echo $question->getTitle() ?></h1>

<div id="favorite-container">
    <p class="action" id="favorite_zone">

        <span><?php echo UserFavoritePeer::getFavoriteCountByQuestionId($question->getId()) ?></span>

        <?php echo jq_link_to_remote("Favorite", array(
        'update'   => 'favorite-container',
        'url'      => 'question/favoriteQuestion?question_id='.$question->getId()
        ),
        array(
        'class' => 'favorite'.$status,
        'title' => 'Click to add question to your favorites list, click again to remove.'
        )
        ) ?>

        <?php echo link_to("Rss", "@rss_for_question_detail?questionId=".$question->getId(), array("class" => 'rss2', 'title' => 'Follow this question in your favorite RSS reader')) ?>
    </p>
</div>

<div class="info question">

    <p class="dates">

        <fb:like layout="button_count" width="50"></fb:like>

        Asked <span class="hour"><?php echo date_age_tag($question->getCreatedAt()) ?></span> |
        Viewed <span class="hour"><strong><?php echo $question->getVisited() ?></strong> times</span> |
        Updated <span class="hour"><?php echo date_age_tag($question->getUpdatedAt()) ?></span> |

        <?php if(!$sf_context->getUser()->hasCredential('offensive-spamer') && $sf_context->getUser()->isAuthenticated()): ?>
            <?php echo jq_link_to_remote('Offensive?',
            array(
            'url'    => 'question/offensiveQuestion?questionId='.$question->getId(),
            'update' => 'offensive'
            ),
            array(
            'title'   => 'Mark this post as offensive, or spam',
            'confirm' => sfConfig::get('app_offensive_confirmation_text')
            )
            ) ?>
        <?php endif; ?>
    </p>
    <p>

    </p>
    <div id="offensive"></div>

    <div id="num<?php echo $question->getId() ?>">

        <p class="votes <?php echo $vote_type ?>">

            <?php $countVote = $question->getTotalVotes() ?>

            <span class="sub">
                <?php echo jq_link_to_remote('-',
                array(
                'update' => "num".$question->getId(),
                'url'    => '@question_detail_vote_for_question?question_id='.$question->getId().'&vote=sub'
                ),
                array(
                'title'  => 'This is a poor question?(click again to undo)',
                'class'  => isset($vote) ? ((isset($vote) && $vote) ? '' : 'vote') : ''
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
                'title'  => 'This is a good question?(click again to undo)',
                'class'  => ((!is_null($vote) && $vote) ? 'vote' : '')
                ))
                ?>
            </span>

        </p>

    </div>

</div><!-- .info -->

<?php if($question->getLocked()): ?>

    <?php echo include_component('question', 'lockedNotification', array('question_id' => $question->getId())) ?>

<?php endif; ?>

<div class="wrap-post">

    <div class="post">
        <p class="avatar">
            <a href="#">
                <?php echo link_to(gravatar_image_tag($question->getUser()->getEmail()), "@authorProfile?userId=".$question->getUser()->getId()) ?>
                <?php if($user->getDisplayName()): ?>
                    <?php echo link_to($user->getDisplayName(), "@authorProfile?userId=".$question->getUser()->getId()) ?>
                <?php else: ?>
                    <?php echo  link_to($sf_context->getUser()->getUserOpenIdInfo(), "@authorProfile?userId=".$question->getUser()->getId()) ; ?>
                <?php endif; ?>
            </a>
        </p>

        <p class="question-content"><?php echo $sf_data->getRaw('question')->getDescription() ?></p>

        <div class="adsense" style="">

           <script type="text/javascript"><!--
            google_ad_client = "pub-9946569006228459";
            /* 468x60, created 2/19/10 */
            google_ad_slot = "8359671585";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>

        </div>

    </div><!-- .post -->


    <?php echo include_component('question', 'tags', array('question' => $question)) ?>


    <div id="after_save_question_comment<?php echo $question->getId() ?>">

        <div id="questionComments<?php echo $question->getId() ?>">

            <?php echo include_partial('question/comments', array(
            'type'          => 'question',
            'id'            => $question->getId(),
            'comments'      => $questionComments,
            'limitComment'  => true
            )
            ) ?>

            <?php echo jq_link_to_remote('Add a Comment',
            array(
            'update'   => 'add_question_comment_'.$question->getId(),
            'url'      => 'question/addQuestionComment?question_id='.$question->getId(),
            'position' => 'bottom'
            ),
            array(
            'class' => 'add-comment'
            )
            ) ?>

            <div id="add_question_comment_<?php echo $question->getId() ?>"></div>

        </div>

    </div>

</div><!-- .wrap-post -->