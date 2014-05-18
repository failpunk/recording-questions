<?php if($ownQuestion || $is_admin || $score >= sfConfig::get('app_experience_needed_edit_tags')): ?>

    <br/>
    <div class="question-admin-controls">

        <span class="container">

        <?php if($ownQuestion || $is_admin): ?>

            <?php echo link_to('Edit', "@question_edit?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(), array('title' => 'Edit this post')) ?>

        <?php else: ?>

            <?php echo link_to('Edit Tags', "@question_edit_tags?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(), array('title' => 'Edit this posts tags')) ?>

        <?php endif ?>

        <?php // Delete Button ?>
        <?php if($ownQuestion || $is_admin): ?>

            <?php if($isDeleted): ?>

                | <?php echo link_to('Undelete', "@question_undelete?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(), array('title' => 'Undelete this post')) ?>

            <?php else: ?>

                | <?php echo link_to('Delete', "@question_delete?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(), array("confirm" => "Are you sure you want to delete this question?", 'title' => 'Delete this post')) ?>

            <?php endif; ?>

        <?php endif ?>
                

        <?php // Lock Button ?>
        <?php if($is_admin): ?>

            <?php if($isLocked): ?>

                | <?php echo link_to('Unlock', "@question_unlock?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId(), array('title' => 'Unlock this post')) ?>

            <?php else: ?>

                | <a id="question-lock" href="#">Lock</a>
                
            <?php endif; ?>

        <?php endif; ?>

        </span>

    </div>

    <?php if($is_admin): ?>

        <div id="question-lock-options" class="small-alert" style="display: none;">

            <p><strong>Why are you locking this Question?</strong></p>

            <?php echo form_tag("@question_lock?question_id=".$question->getId(), array('method' => 'post','id' => 'question-lock-form')) ?>

                <ul>

                    <li><a href="#">It is a duplicate question</a></li>
                    <li><a href="#">It is poorly worded or vague</a></li>
                    <li><a href="#">It is not related to recording</a></li>
                    <li><a href="#">It is offensive or hateful</a></li>
                    <li><a href="#">It is spam</a></li>

                </ul>

                <span id="question-lock-duplicate" style="display: none;">
                    Enter the id # of the duplicate question:
                        <?php echo input_tag('question-lock-duplicate-id') ?>
                    <a href="#">submit</a>
                </span>

                <?php echo input_hidden_tag('question-lock-reason') ?>

            </form>

            <p class="close"><a onclick="xhide('question-lock-options');">X</a></p>

        </div>

    <?php endif ?>

<?php endif; // end admin if block ?>