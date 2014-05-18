<?php use_helper('Form', 'Gravatar', 'custom') ?>

<ul class="list-users clearfix">

<?php if($no_results): ?>

    <li>

        <p class="user-stats-1">

               <span class="user-name">

                   <a href="#">-- No Users Were Found</a>

               </span>

        </p>

    </li>

<?php else: ?>
    
    <?php foreach($users as $user): ?>

        <li>

            <p class="user-avatar"><?php echo link_to(gravatar_image_tag($user['email'], ''), "@authorProfile?userId=".$user['id'])?></p>

            <p class="user-stats-1">

                <span class="user-name">

                    <a href="<?php echo url_for("@authorProfile?userId=".$user['id']) ?>"><?php echo $user['display_name'] ?></a>

                </span>

                - Experience Score: <span class="score"><?php echo $user['experience_score'] ?></span>

                - Awards: <span class="user-win">(<?php echo $user['award_count'] ?>)</span>
                -

            </p>

            <p class="user-stats-2">

                Questions: <span class="ask">Asked:</span> <strong><?php echo $user['question_count'] ?></strong> |

                Questions: <span class="answer2">Answered:</span> <strong><?php echo $user['answer_count'] ?></strong> |

                Votes Given: <span class="votes-given"><?php echo $user['question_vote_count'] + $user['answer_vote_count'] ?></span> |

            </p>

        </li>

     <?php endforeach ?>

<?php endif ?>
</ul>