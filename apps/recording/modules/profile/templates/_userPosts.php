<?php //@profile_show_question?questionPage=1&userId='.$user->getId() ?>

<p class="show-comments expanded">Hide All Posts</p>

<span class="post-list">

    <div>

        <ul>
            <?php // Question Code ?>
            <?php if($type == 'question'): ?>

                <?php foreach ($userPosts->getResults() as $post): ?>

                    <li>
                       <?php echo link_to($post->getTitle(), "@question_detail?question_title=".myUtil::createSlug($post->getTitle())."&question_id=".$post->getId()) ?>
                       <?php if($sf_context->getUser()->isAuthenticated() && $thisUser): ?>
                           <?php echo link_to('Edit', "@question_edit?question_title=".myUtil::createSlug($post->getTitle())."&question_id=".$post->getId(), array('title' => 'Edit this post', 'class' => 'edit')) ?>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>

            <?php else: ?>

                <?php // Answer Code ?>
                <?php foreach ($userPosts->getResults() as $post): ?>
                
                    <?php $answer_text = trim(strip_tags(html_entity_decode($post->getAnswer()))) ?>
                    <?php $answer_text = substr($answer_text, 0, sfConfig::get('app_statistics_page_answer_length')) ?>

                    <?php $question_title = $post->getQuestion()->getTitle() ?>

                    <li>
                       <?php echo link_to($answer_text.'...', "@question_detail?question_title=".myUtil::createSlug($question_title)."&question_id=".$post->getQuestionId()."#".$post->getId()) ?>
                       <?php if($sf_context->getUser()->isAuthenticated() && $thisUser): ?>
                           <?php echo link_to('Edit', "@answer_edit?answer_id=".$post->getId(), array('title' => 'Edit this post', 'class' => 'edit')) ?>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>

            <?php endif ?>

        </ul>

        <?php ////TODO: Justin - add functionality to show more posts ?>
        <?php if($userPosts->getNbResults() > 1500):  ?>
            <p class="next-answ"><a href="#">Next 15 <?php echo ucfirst($type) ?>s »</a></p>
        <?php endif ?>
        
    </div>

</span>