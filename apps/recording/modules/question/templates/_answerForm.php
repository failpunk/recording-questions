<?php
/* 
 * Displays any comments for the Question Detail page
 */
 ?>

 <?php $form_display = "display:block;" ?>
 
 <?php if(!$question->getLocked()): ?>

    <?php // if user is signed in and and this is their own question, make sure they know they can comment. ?>
    <?php if($sf_context->getUser()->isAuthenticated() && $sf_context->getUser()->getCurrentUser()->getId() == $question->getUserId()): ?>
        <input id="answer-own-question" type="submit" class="submit" value="Answer Your Own Question" />

        <p class="popup three" style="display: none; width: 598px;">
            Are you sure you are leaving an answer to your own question? If you want to respond to something someone else said, use the <strong>'Add a Comment'</strong> link near each post.<br/>
            <a id="answer-show-form" href="/login">Yes, I want to answer my own question</a>
        </p>

        <?php $form_display = "display:none;" ?>
    <?php endif ?>
    

    <?php echo form_tag("@answer_question", array('method' => 'post', 'class' => 'answer-question', 'id' => 'answer-form', 'style' => $form_display)) ?>


        <h3>Answer this question</h3>

        <!--
        <div class="settings">
            <p class="info"><a href="#">Info</a></p>
        </div>
        -->

        <div class="message">
            <p>(If you are simply responding and not posting an answer, consider leaving a comment instead)</p>
        </div>

        <p>
            <?php echo textarea_tag('answer', $sf_params->get('answer'), initTinyMce()) ?>
        </p>

        <p>
            <?php if($sf_user->hasCredential('answer-spamer') || !$sf_user->hasCredential('user') ): ?>
                <?php echo captchagd();  ?>
                <?php if ($sf_request->hasError('answer_captcha')) echo form_error('answer_captcha') ?>

                <p class="sinthetizers"><?php echo input_tag("answer_captcha", '', array('class' => 'text')) ?></p>
                <?php else: ?>
                   <p style="display: none"><?php echo input_tag("answer_captcha", '0000', array('class' => 'text')) ?></p>
            <?php endif; ?>
        </p>

        <p class="submit">
            <?php echo input_hidden_tag("question_id", $question->getId()) ?>
            <input type="submit" class="submit" value="Submit your Answer" />
        </p>

        <?php if(!$sf_context->getUser()->isAuthenticated()): ?>
            <p class="not-signed-in">
                You are currently not signed-in!  You can still post this answer but you will not receive credit for it.<br/>
                <a href="<?php echo url_for('@login') ?>">Sign In Now!</a>
            </p>
        <?php endif ?>

    </form>

<?php endif ?>