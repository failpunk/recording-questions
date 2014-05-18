<?php use_helper('Form', 'Validation', 'jQuery', 'myJquery', 'custom'); ?>

<div id="content">

    <div id="main">

        <h1 class="title">Edit Question Tags</h1>

        <p>Help other members of the community find this question by keeping its tags as accurate as possible.  Be sure all the tags are related to the original owner's question and comments and not to the answers.</p>

        <?php echo form_tag('@question_edit_tags', array('class' => 'ask-question')) ?>
        
        <ol class="fieldset">

            <li class="field">

                <h4><?php echo $question->getTitle() ?></h4>

                <p class="fields">

                    <?php echo html_entity_decode($question->getDescription()) ?>

                </p>

            </li>

            <li class="field">

                <?php if ($sf_request->hasErrors()): ?>
    
                <div class="popup one profile-error">

                    <p>Whoops, There are a few errors you must fix before submitting your question:</p>

                    <ul class="error_list">
                            <?php $form_errors = $sf_request->getErrors() ?>
                            <?php foreach($form_errors as $error): ?>
                        <li><?php echo $error ?></li>
                            <?php endforeach ?>
                    </ul>

                </div>

                <?php endif; ?>

            </li>

            <li class="field">

                <h4>Tags<span> ( help others find this question )</span></h4>
                
                <?php foreach ($question->getTags() as $tag): ?>
                    <?php $tagStr[] = $tag ?>
                <?php endforeach; ?>

                <p class="sinthetizers"><?php echo jq_input_auto_complete_tag('question_tags', implode(' ', $tagStr),
                    'question/autocomplitTags',
                    array(
                        'autocomplete' => 'off',
                        'type' => 'text',
                        'class' => 'text'
                    ),
                    array(
                        'use_style'         => true,
                        'multipleSeparator' => ' ',
                        'multiple'          => true
                    )
                    ) ?>
                </p>

                <p class="txt01">Combine multiple words together with a hyphen, use spaces to separate up to 5 tags (mix analog adam-audio)</p>

            </li>

            <li class="field">

                <? if($sf_user->hasCredential('question-spamer') || !$sf_user->hasCredential('user') ): ?>
                    <?php echo captchagd();  ?>
                    <?php if ($sf_request->hasError('question_captcha')) echo form_error('question_captcha') ?>

                <p class="sinthetizers"><?php echo input_tag("question_captcha", '', array('class' => 'text')) ?></p>
                <?php else: ?>
                <p style="display: none"><?php echo input_tag("question_captcha", '0000', array('class' => 'text')) ?></p>
                <?php endif; ?>
            </li>
            
        </ol>

        <?php echo input_hidden_tag("question_id", $question->getId()) ?>
        
        <p class="ask-your-question"><?php echo submit_tag("Save change", array('type' => 'submit', 'class' => 'submit')) ?></p>

        </form>

    </div><!-- / #main -->

    <div id="sidebar">

        <div class="wrap-box">

            <div class="box">

                <h3>What Are Tags?</h3>

                <p>Tags are used to help other Recording Question members find questions of interest so they may answer them.</p>

                <p>They also help with search by letting the system know what your questions are really about.</p>

                <p>Can't find the tag you're looking for in the drop down list?  You can add new tags once you have enough experience.</p>

            </div><!-- .box -->

        </div><!-- .wrap-box -->

    </div><!-- / #sidebar -->

</div><!-- / #content -->
