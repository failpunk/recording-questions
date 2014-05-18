<?php use_helper('Form', 'jQuery', 'custom', 'Validation', 'tooltips'); ?>

<script type="text/javascript">
    
    $().ready(function()
    {
        // show switch text link to say loading
        $('#comment_p_<?php echo $answerId ?> input').click(function() {
            $(this).val('Saving Comment...')
        });

        $('#new-answer-comment').each(function() {
            var length = $(this).val().length;
            $("#char-counter-<?php echo $answerId ?> span").html( 450 - length);
            $(this).keyup(function(){
                var new_length = 450 - $(this).val().length;

                $("#char-counter-<?php echo $answerId ?> span").html(new_length);
                var counter = $("#char-counter-<?php echo $answerId ?>");

                counter.removeClass();
                if(new_length < 25) {
                    counter.addClass('char-counter-red');
                }

                if(new_length < 50) {
                    counter.addClass('char-counter-yellow');
                }

                if(new_length >= 50) {
                    counter.addClass('char-counter-green');
                }
            });
        });
        
    });

</script>

<?php if(isset($negativAddComment) && !$negativAddComment): ?>

    <?php echo jq_form_remote_tag(
           array(
                 'update'   => 'after_save_comment'.$answerId,

                 'url'      => 'question/saveComment?answer_id='.$answerId,
                ),
           array(
                 'class' => 'comment'
                )
    ) ?>

        <h5>Post your Comment</h5>

        <p>
            <div class="resizable-textarea">
                <span>
                    <textarea id="new-answer-comment" name="comment" rows="5" cols="5" class="textarea resizable processed" />
                    <div class="grippie" style="margin-right: -1px;"></div>
                </span>
            </div>
        </p>

        <p id="char-counter-<?php echo $answerId ?>" class="char-counter-green" style="">
            <span>450</span> characters remaining
        </p>

        <p>

        <?php if($sf_user->hasCredential('comment-spamer') || !$sf_user->hasCredential('user') ): ?>
            <?php echo captchagd();  ?>
            <?php if ($sf_request->hasError('comment_captcha')) echo form_error('comment_captcha') ?>

            <p class="sinthetizers"><?php echo input_tag("comment_captcha", '', array('class' => 'text')) ?></p>
            <?php else: ?>
                <p style="display: none"><?php echo input_tag("comment_captcha", '0000', array('class' => 'text')) ?></p>
            <?php endif; ?>

        </p>
        <p id="comment_p_<?php echo $answerId ?>" class="submit">
           <input type="submit" class="submit" value="Submit" />
           <?php echo input_hidden_tag('question_id', $questionId) ?>
        </p>
        
    </form>

<?php else: ?>

    <div style="position: static">
    <?php echo dispalay_tooltip("AnswerComment", '');  ?>
    </div>

<?php endif; ?>