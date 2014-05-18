<?php use_helper('Gravatar', 'custom') ?>


<ol id="searchResults" class="<?php echo $list_class ?>">

    <?php foreach ($sf_data->getRaw('questions')->getResults() as $question): ?>

    <li>

        <h4><?php echo link_to($question->getTitle(), Question::constructQuestionRoute($question->getTitle(), $question->getId())) ?></h4>

        <a href="<?php echo url_for($question->getUser()->getRoute()) ?>">
            <p class="avatar"><?php echo gravatar_image_tag($question->getUser()->getEmail())?></p>
        </a>

        <?php if($list_class != ""): ?>
        <p id="favorite_zone<?php echo $question->getId() ?>">

            <?php if($sf_context->getUser()->getCurrentUser()->getId() == $ownerId): ?>

               <?php echo jq_link_to_remote("Favorite", array(
                        'update'   => 'favorite_zone'.$question->getId(),
                        'url'      => 'profile/favoriteQuestion?question_id='.$question->getId()
                    ),
                    array(
                        'class' => 'favorite',
                        'title' => 'Click to add question to your favorites list, click again to remove.'
                    )
               ) ?>

                <span class="count"><?php echo UserFavoritePeer::getFavoriteCountByQuestionId($question->getId()) ?></span>

            <?php endif; ?>

        </p>
        <?php endif ?>

        <?php if(!$display_compact): ?>
            <p><?php echo substr(strip_tags($question->getDescription()), 0, sfConfig::get('app_question_description_length')) ?></p>
        <?php endif ?>

        <p class="info">

            <?php echo link_to("Rss", "@rss_for_question_detail?questionId=".$question->getId(), array("class" => 'rss', 'title' => 'Add to your favorite rss reader')) ?>

            <a href="mailto:?subject=Recording Question&body=Check out this recording question:%0D%0A<?php echo url_for(Question::constructQuestionRoute($question->getTitle(), $question->getId()), true) ?>" title="Email to a friend" class="email">
                Email
            </a>
            
            <?php if($has_twitter): ?>
                <a href="#" tweet="<?php echo $question->getId() ?>" title="Tweet this" class="send-tweet">
                    Tweet
                </a>
            <?php endif ?>

            viewed <a class="times" href="#"><strong><?php echo $question->getVisited() ?></strong> times</a> |
            asked by

            <?php if($question->getUser()->getIsGuest()): ?>
                <a>guest</a>
            <?php else: ?>
                <?php echo link_to($question->getUser()->getDisplayName(), $question->getUser()->getRoute()) ?>
            <?php endif; ?>

            <?php echo date_age_tag($question->getCreatedAt()) ?>

        </p>

        <?php echo include_component('question', 'tags', array('question' => $question)) ?>

        <?php // Color code the boxes ?>
        <?php $bestAnswer = false; ?>
        <?php $answer_count = (is_null($question->getColumn('total_answer'))) ? 0 : $question->getColumn('total_answer') ?>
        <?php $best_answer = (is_null($question->getColumn('best_answer'))) ? 0 : $question->getColumn('best_answer') ?>

        <?php if($answer_count < 1): ?>
            <?php $vote_css_class = 'answvot-grey' ?>
        <?php elseif($best_answer): ?>
            <?php $vote_css_class = 'answvot-best' ?>
        <?php else: ?>
            <?php $vote_css_class = 'answvot-normal' ?>
        <?php endif; ?>

        <div class="<?php echo $vote_css_class ?>"">

            <p class="answer">
                <?php echo link_to('<span class="num">'.$answer_count.'</span>Answers', Question::constructQuestionRoute($question->getTitle(), $question->getId())) ?></a>
            </p>

            <p class="vot"><a href="#"><span class="num"><?php echo $question->getTotalVotes() ?></span>Votes</a></p>

        </div>

    </li>

    <?php endforeach; ?>

</ol><!-- / #searchResults -->

<?php echo input_hidden_tag('send-tweet-route', url_for('@ajax_tweet')) ?>

<?php include_component('index', 'pagination', array('pager' => $questions, 'route' => $base_route)) ?>