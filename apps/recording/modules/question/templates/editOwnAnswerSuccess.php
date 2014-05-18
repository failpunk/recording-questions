<?php use_helper('Form', 'Validation', 'jQuery', 'myJquery', 'custom'); ?>

<div id="content">

<div id="main">

<h1 class="title">Edit Recording Answer</h1>

 <?php echo form_tag('question/editOwnAnswer', array('class' => 'ask-question')) ?>
<ol class="fieldset">

	<li class="field">

        <h4>Answer</h4>

        <p class="fields"><?php echo textarea_tag('answer', $answer->getAnswer(), initTinyMce()) ?></p>

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

</ol>

<?php echo input_hidden_tag("answer_id", $answer->getId()) ?>
<?php echo input_hidden_tag("save", true) ?>
<p class="ask-your-question"><?php echo submit_tag("Save change", array('type' => 'submit', 'class' => 'submit')) ?></p>

</form>
</div>
</div>