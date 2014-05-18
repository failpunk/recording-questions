<?php
/* 
 * Displays the Question of the question detail page
 */
 ?>

<ol class="comments">

    <?php foreach ($sf_data->getRaw('answers') as $answer): ?>

        <?php if($answer->getBestanswer()): ?>
            
            <?php $bestAnswer = true; ?>

            <div class="best-answer">

            <?php if($user_question): ?>
                <h4 title="You think this is the best answer (Click again to undo)"><?php echo link_to("Best Answer", '@question_best_answer?question_id='.$question->getId().'&answer_id='.$answer->getId()) ?></h4>
            <?php else: ?>
                <h4 title="The person that asked this question thinks this is the best answer"><a class="no-hover" href="#">Best Answer</a></h4>
            <?php endif; ?>

        <?php elseif($user_question): ?>

            <h4><?php echo link_to("Select As Best Answer", '@question_best_answer?question_id='.$question->getId().'&answer_id='.$answer->getId()) ?></h4>

        <?php endif; ?>
        
        <li>

        <div class="info answer" id="<?php echo $answer->getId() ?>">

            <p class="dates">

                Answered: <?php echo date_age_tag($answer->getCreatedAt()) ?>
                
                <a href="#answerComments<?php echo $answer->getId() ?>" class="total-comments" title="There are <?php echo $answer->getColumn("total_answer_comment") ?> comments on this post">(<?php echo $answer->getColumn("total_answer_comment") ?>)</a> |

                <?php if(!$sf_context->getUser()->hasCredential('offensive-spamer') && $sf_context->getUser()->isAuthenticated() ): ?>

                    <?php echo jq_link_to_remote('Offensive?',
                                               array(
                                                      'url'    => 'question/offensiveAnswer?answerId='.$answer->getId(),
                                                      'update' => 'offensive'.$answer->getId()
                                               ),
                                               array(
                                                      'title' => 'Mark this post as offensive, or spam',
                                                      'confirm' => sfConfig::get('app_offensive_confirmation_text')
                                               )
                    ) ?> |
                    
                <?php endif; ?>
                
                <?php echo link_to('Permalink', '@question_detail?question_title='.myUtil::createSlug($question->getTitle()).'&question_id='.$question->getId().'#'.$answer->getId(), array('title' => 'Create a link to this post')) ?>

            </p>
            
            <div id="offensive<?php $answer->getId() ?>"></div>

            <?php
                $voteValue = $sf_data->getRaw('answerVote');
                $vote_type = '';

                if(!is_null($voteValue) && count($voteValue) > 0 && array_key_exists($answer->getId(), $voteValue))
                {
                    if($voteValue[$answer->getId()]->getPositive()) {
                        $preVote = true;
                        $vote_type = 'add';
                    }
                    if($voteValue[$answer->getId()]->getNegative()) {
                        $preVote = false;
                        $vote_type = 'sub';
                    }
                }
            ?>

            <div id="answerNum<?php echo $answer->getId()?>">
            
                <p class="votes <?php echo $vote_type ?>">

                    <span class="sub">

                        <?php echo jq_link_to_remote('-',
                                      array(
                                        'update' => "answerNum".$answer->getId(),
                                        'url'    => '@question_detail_vote_for_answer?answer_id='.$answer->getId().'&vote=sub'
                                      ),
                                      array(
                                        'title'  => 'This is a poor answer?(click again to undo)',
                                        'class'  => (isset($preVote) ? ((!is_null($preVote) && $preVote) ? '' : 'vote' ) : '')
                                      ))
                        ?>

                    </span>

                    <span class="num" id="answerNum<?php echo $answer->getId() ?>"><?php echo $answer->getTotalVotes() ?></span>

                    <?php // $countVote = $answer->getTotalVotes() ?>

                    <span class="add">

                        <?php echo jq_link_to_remote('+',
                          array(
                            'update' => "answerNum".$answer->getId(),
                            'url'    => '@question_detail_vote_for_answer?answer_id='.$answer->getId().'&vote=add'
                          ),
                          array(
                            'title'  => 'This is a good answer?(click again to undo)',
                            'class'  => ((isset($preVote) && $preVote) ? 'vote' : '' )
                          ))
                        ?>

                    </span>

                    <?php unset($preVote) ?>

                </p><!-- .votes -->

            </div><!-- #answerNum -->

        </div><!-- .info -->

        <?php if(($sf_context->getUser()->isAuthenticated() && sfContext::getInstance()->getUser()->getCurrentUser()->getId() == $answer->getUserId()) || $sf_context->getUser()->hasCredential('admin')): ?>
            <!-- Admin Control Links -->
            <div class="answer-admin-controls">
              <span class="container">
                  <?php echo link_to('Edit', "@answer_edit?&answer_id=".$answer->getId(), array('title' => 'Edit this post')) ?> |
                  <?php echo link_to("Delete", "@answer_delete?answer_id=".$answer->getId(), array("confirm" => "Are you sure you want to delete this answer?", 'title' => 'Delete this post')); ?>
              </span>
            </div>
        <?php endif; ?>

        <div class="wrap-post" id="comment">

            <div class="post">

                <p class="avatar">
                
                    <a href="<?php echo url_for('@authorProfile?userId='.$answer->getUser()->getId()) ?>">
                        <?php echo gravatar_image_tag($answer->getUser()->getEmail())?><?php echo $answer->getUser()->getDisplayName() ?>
                    </a>

                </p>

                <p class="answer-content"><?php echo $answer->getAnswer() ?></p>

            </div>

            <div id="after_save_comment<?php echo $answer->getId()  ?>">

                <div id="answerComments<?php echo $answer->getId() ?>">

                    <?php echo include_partial('question/comments', array(
                            'type'          => 'answer',
                            'id'            => $answer->getId(),
                            'comments'      => $answer->getAnswerComments(),
                            'limitComment'  => true,
                            'questionId'    => $question->getId()
                        )
                    ) ?>

                    <?php echo jq_link_to_remote('Add a Comment',
                            array(
                                    'update' => 'add_comment_'.$answer->getId(),
                                     'url'    => 'question/addComment?answer_id='.$answer->getId().'&question_id='.$question->getId()
                                 ),
                            array(
                                    'class' => 'add-comment'
                                 )
                    ) ?>

                    <div id="add_comment_<?php echo $answer->getId()  ?>"></div>

                </div>

            </div>

            

        </div><!-- .wrap-post -->

    <?php if($answer->getBestanswer()): ?>
        </div><!-- .best-answer -->
    <?php endif ?>

        </li>
        
    <?php endforeach; ?>

</ol><!-- .comments -->