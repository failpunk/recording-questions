<?php use_helper('Form', 'Validation', 'jQuery', 'myJquery', 'custom'); ?>

<div id="content">

    <div id="main">

        <h1 class="title">Edit Question</h1>

        <?php echo form_tag('@question_edit', array('class' => 'ask-question')) ?>

        <ol class="fieldset">

            <li class="field">

                <h4>Title<span> ( be descriptive )</span></h4>

                <p class="title"><?php echo input_tag('question[title]', $question->getTitle(),
                    array(
                    'class'   => 'text',
                    'id'      => 'title'
                    )) ?>
                    <span class="error"></span>
                </p>

                <?php echo jq_observe_field('title', array(
                    'update'   => 'related',
                    'url'      => 'question/search',
                    'with'     => "'q=' + value"
                )) ?>
                <div id="related"></div>

                <div class="settings">

                    <!--<p class="info"><a href="#">Info</a></p>-->

                </div>

                <h4>Detailed Description</h4>

                <p class="fields"><?php echo textarea_tag('question[description]', $question->getDescription(), initTinyMce()) ?></p>

            </li>

            <li class="field">

                <!--
                <h4>Question Preview</h4>

                <div class="box-preview">

                    <p></p>

                    <p>
                        <strong></strong>
                    </p>

                </div>-->

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

                <h4>Tags<span> ( help others find your question )</span></h4>

                <?php $tags = $question->getTags() ?>
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
                    ) ?></p>

                <p class="txt01">Combine multiple words together with a hyphen, use a space to separate up to 5 tags (guitar analog adam-audio)</p>

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
        <?php echo input_hidden_tag("save", true) ?>
        <p class="ask-your-question"><?php echo submit_tag("Save change", array('type' => 'submit', 'class' => 'submit')) ?></p>

        </form>

    </div><!-- / #main -->

    <div id="sidebar">

        <div class="wrap-box">

            <div class="box first">

                <h3>Asking a Question</h3>

                <p>Is your question related ro recording?</p>

                <p>Try to post questions that can be answered by other users and not just discussed.</p>

                <p>This is not a message board.</p>

                <p>Be sure to phrase your question as simply and as clearly as possible in as much detail as possible.</p>

                <p class="see"><a href="#">See FAQs for more information</a></p>

            </div><!-- .box -->

            <div class="box">

                <h3>What Are Tags?</h3>

                <p>Tags are used to help other Recording Question members find questions of interest so they may answer them.</p>

                <p>They also help with search by letting the system know what your questions are really about.</p>

                <p>Can't find the tag you're looking for in the drop down list?  You can add new tags once you have enough experience.</p>

            </div><!-- .box -->

        </div><!-- .wrap-box -->
    
    </div><!-- / #sidebar -->

</div><!-- / #content -->
