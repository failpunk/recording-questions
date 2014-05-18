<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php

    $post_title = $question->getTitle();

    $type = 'comment';
    $title = 'Someone Has Commented on your Question';
    $post_id = $comment->getId();
    $from_name = $comment->getUser()->getDisplayName();
    $content = $comment->getDescription();

    // if sending to owner of answer
    if(isset ($answer)) {
        $title = 'Someone Has Commented on your Answer';
    }

?>

<body id="newsletter">

    <div class="header">

        <a href="<?php echo url_for('@homepage') ?>"><img border="0" src="http://martini.recordingquestions.com/images/newsletter/logo.gif" /></a>

    </div>

    <div id="content">

        <h1 style="font-size:1.75em; font-weight:bold;">
            <a style="color:#5DAAD6;" class="main" href="<?php echo url_for("@question_detail?question_title=".myUtil::createSlug($question->getTitle())."&question_id=".$question->getId()."#".$post_id, true) ?>"><?php echo $title ?>!</a>
        </h1>

        <h3 style="color:#245876; font-size:1.5em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em; border-bottom:1px solid #dddddd;">
            <?php echo $post_title ?>
        </h3>

        <p style="font-size:1em; margin-bottom:1em; color:#000000;">
            <?php echo $from_name ?> posted a new <?php echo $type ?> for you:
        </p>

        <div style="padding:5px 5px 5px 30px; background:#EFF6F9;">
            <?php echo html_entity_decode($content) ?>
        </div>


        <h3 style="color:#245876; font-size:1.25em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em;">Remember to Vote.</h3>

        <p style="font-size:1em; margin-bottom:1em; color:#000000;">
            Voting helps separate to good from the bad. Please vote for the answers and questions that you think are most interesting and well thought out.
        </p>


        <p style="font-weight:bold; color:#245876;">Best Regards,<br/><span>~ Team Recording Questions</span></p>

    </div>

</body>
</html>