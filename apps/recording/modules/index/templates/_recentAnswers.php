<div class="greenSidebar recent-answers">

    <h3>Recent Answers</h3>

    <ul>
        
        <?php foreach($answers as $answer): ?>
        <li>

            <?php echo link_to($answer["User.DisplayName"], '@profile?display_name='.myUtil::slugify($answer['User.DisplayName']).'&userId='.$answer['Answer.UserId']) ?>
            <span><?php echo date_age_tag($answer['Answer.CreatedAt']) ?></span>
            <p>
                <a href="<?php echo url_for(Answer::constructAnswerRoute($answer['Question.Title'], $answer['Answer.QuestionId'], $answer['Answer.Id'])) ?>">
                    <?php echo Answer::getShortenedDescription($answer['Answer.Answer']) ?>
                </a>
            </p>

        </li>
        <?php endforeach ?>

    </ul>

</div>