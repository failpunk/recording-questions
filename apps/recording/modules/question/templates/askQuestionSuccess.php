<?php use_helper('Form', 'Validation', 'jQuery', 'myJquery', 'custom'); ?>


<div id="content">

<?php if(isset($isSpam)): ?>
    <div style="opacity: .4;">
<?php endif ?>

<div id="main">

    <h1 class="title">Ask a New Recording Question</h1>

    <?php echo form_tag('question/askQuestion', array('class' => 'ask-question')) ?>

    <ol class="fieldset">

        <li class="field">

        <h4>Title<span> ( The first thing everyone will see )</span></h4>

        <p class="title"><?php echo input_tag('question[title]', $sf_params->get('question[title]'),
            array(
                'class'     => 'text',
                'id'        => 'title',
                'tabindex'  => '1'
            )) ?>
            <span class="error"></span>
        </p>

        <?php echo jq_observe_field('title', array(
                'update'   => 'related',
                'url'      => 'question/search',
                'with'     => "'q=' + value"
                ))
        ?>

        <div id="related"></div>

        <h4>Detailed Description<span> ( Add lots of detail for better answers )</span></h4>

        <p class="fields">
            <?php echo textarea_tag('question[description]', $sf_params->get('question[description]'), initTinyMce()) ?>
        </p>

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

            <p class="sinthetizers"><?php echo jq_input_auto_complete_tag('question_tags', $sf_params->get('question_tags'),
                                        'question/autocomplitTags',
                                         array(
                                             'autocomplete' => 'off',
                                             'type' => 'text',
                                             'class' => 'text',
                                             'tabindex' => '3'
                                             ),
                                             array(
                                                 'use_style'         => true,
                                                 'multipleSeparator' => ' ',
                                                 'multiple'          => true
                                             )
                                         ) ?></p>

        <p class="txt01">Combine multiple words together with a hyphen, use a space to
        separate up to 5 tags (guitar analog adam-audio)</p>

        </li>

    <!--
        <li class="field">

            <?php //if($sf_user->hasCredential('question-spamer') || !$sf_user->hasCredential('user') ): ?>
            <?php //echo captchagd();  ?>
            <?php //if ($sf_request->hasError('question_captcha')) echo form_error('question_captcha') ?>

            <p class="sinthetizers"><?php //echo input_tag("question_captcha", '', array(
                                          //                                          'class' => 'text',
                                          //                                          'tabindex' => '4'
                                          //                                       )) ?>
            </p>

            <?php //else: ?>
               <p style="display: none"><?php //echo input_tag("question_captcha", '0000', array('class' => 'text')) ?></p>
            <?php //endif; ?>
        </li>
    -->

        <!-- Email Reminder -->
        <li class="field">
            <h4>Email Reminder<span> ( we can notify you when someone responds )</span></h4>
            <p class="sinthetizers">
                <?php $email_is_checked = (isset($notify_email_checked) && $notify_email_checked == true) ? $notify_email_checked : false ?>
                <?php $email_textbox_class = (isset($notify_email_checked) && $notify_email_checked == true) ? '' : ' disable' ?>
                <?php echo checkbox_tag('notify_checkbox', '1', $email_is_checked) ?>
                <?php echo input_tag("notify_email", $sf_user->getCurrentUser()->getEmail(), array(
                                                                'class' => 'text'.$email_textbox_class,
                                                                'tabindex' => '5'
                                                             )) ?>
            </p>
        </li>

    </ol>

    <?php if(!isset($isSpam)): ?>
        <p class="ask-your-question"><?php echo submit_tag("Ask Your Question", array('type' => 'submit', 'class' => 'submit')) ?></p>
    <?php endif ?>

    </form>
</div><!-- / #main -->

<?php if(isset($isSpam)): ?>
</div><!-- / #disable-div -->
<?php endif ?>

<div id="sidebar">

<div class="wrap-box">

<div class="box first">

<h3>Asking a Question</h3>

<p>Is your question related ro recording?</p>

<p>Try to post questions that can be answered by other users and not
just discussed.</p>

<p>This is not a message board.</p>

<p>Be sure to phrase your question as simply and as clearly as possible
in as much detail as possible.</p>

<p class="see"><a href="<?php echo url_for('@faq') ?>">See FAQs for more information</a></p>

</div>
<!-- .box -->

<div class="box">

<h3>What Are Tags?</h3>

<p>Tags are used to help other Recording Question members find questions of interest so they may answer them.</p>

<p>They also help with search by letting the system know what your questions are really about.</p>

<p>Can't find the tag you're looking for in the drop down list?  You can add new tags once you have enough experience.</p>

</div>
<!-- .box --></div>
<!-- .wrap-box --></div>
<!-- / #sidebar --></div>
<!-- / #content -->
