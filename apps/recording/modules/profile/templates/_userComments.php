<p class="show-comments expanded">Hide All Posts</p>

<span id="questionsList">

    <div>

        <ul>
            <?php // Comment Code ?>
            <?php foreach ($questionComments as $questionComment): ?>

                <li>
                   <?php echo link_to($questionComment['QuestionComment.Description'], "@question_detail?question_title=".myUtil::createSlug($questionComment['Question.Title'])."&question_id=".$questionComment['Question.Id']) ?>
                   <?php if($sf_context->getUser()->isAuthenticated() && $thisUser): ?>
                       
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>

            <?php foreach ($answerComments as $answerComment): ?>

                <li>
                   <?php echo link_to($answerComment['AnswerComment.Description'], "@question_detail?question_title=".myUtil::createSlug($answerComment['Question.Title'])."&question_id=".$answerComment['Question.Id'].'#'.$answerComment['AnswerComment.AnswerId']) ?>
                   <?php if($sf_context->getUser()->isAuthenticated() && $thisUser): ?>
                   
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>

        </ul>

        <?php ////TODO: Justin - add functionality to show more posts ?>
        <?php if($commentCount > 1500):  ?>
            <p class="next-answ"><a href="#">Next 15 Comments »</a></p>
        <?php endif ?>
        
    </div>

</span>