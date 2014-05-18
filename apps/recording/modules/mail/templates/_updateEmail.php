<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<body id="newsletter">

    <div class="header">

        <a href="http://www.recordingquestions.com"><img border="0" src="http://martini.recordingquestions.com/images/newsletter/logo.gif" /></a>

    </div>

    <div id="content">

        <h1 style="font-size:1.75em; font-weight:bold;">
            <a style="color:#5DAAD6;" class="main" href="http://www.recordingquestions.com">Recent Recording Questions Activity!</a>
        </h1>

        <p style="font-size:1em; margin-bottom:1em; color:#000000;">
            It looks like you've been away for a while, so we though we'd let you know what's been going on.  Here is a list of activity that you may be interested in.
        </p>

        <?php if(count($messages) > 0): ?>

            <h3 style="color:#245876; font-size:1.5em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em; border-bottom:1px solid #dddddd;">
                You Have <?php echo count($messages) ?> New <?php echo (count($messages) > 1) ? 'Updates' : 'Update' ?>
            </h3>

            <ul style="list-style-type: none;">
                <?php foreach($messages as $message): ?>

                    <?php
                    // process the message string
                    $action = html_entity_decode($message->getMessage());

                    // style h4 tags
                    $action = str_replace('<h4>', '<h4 style="font-weight:bold; font-size:1.2em;">', $action);

                    // style p tags
                    $action = str_replace('<p>', '<p style="font-weight:normal; margin-bottom:15px; color:#000000;">', $action);

                    // style ul tags
                    $action = str_replace('<ul>', '<ul style="font-weight:normal; color:#000000;">', $action);

                    // add domain to links
                    $action = str_replace('<a href="', '<a href="http://www.recordingquestions.com', $action);

                    ?>

                    <li style="color:#245876;">
                        <?php echo $action ?>
                    </li>

                <?php endforeach ?>
            </ul>

        <?php endif ?>

        <?php if(count($questions) > 0): ?>

            <h3 style="color:#245876; font-size:1.5em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em; border-bottom:1px solid #dddddd;">
                Most Recent Recording Questions:
            </h3>

            <ul style="list-style-type: none;">

                <?php foreach($questions as $question): ?>

                <li>

                    <a style="text-decoration: underline;" href="<?php echo $question->constructUrlForTask() ?>">
                        <h4 style="font-weight:bold; font-size:1.2em;"><?php echo html_entity_decode($question->getTitle()) ?></h4>
                    </a>

                    <div style="padding:5px 5px 5px 30px; background:#EFF6F9;">

                        <p style="font-weight:normal; margin-bottom:15px; color:#000000;"><?php echo html_entity_decode($question->getDescription()) ?></p>

                    </div>
                
                </li>

                <?php endforeach ?>
                
            </ul>

        <?php endif ?>

        <br/>
        <h3 style="color:#245876; font-size:1.25em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em;">We Want Your Feedback</h3>

        <p style="font-size:1em; margin-bottom:1em; color:#000000;">
            All we ask is that you give us as much feedback as possible.
        </p>

        <ul>
            <li><a href="http://www.recordingquestions.com/question/1/1">Report any bugs you might find while using the site.</a></li>
            <li><a href="http://www.recordingquestions.com/question/1/2">Please relay any suggestions about the website to use so we can make it better.</a></li>
        </ul>

        <h3 style="color:#245876; font-size:1.25em; font-weight:bold; margin-top:1.5em; margin-bottom:.75em;" class="top">Don't Want To Receive This Email?</h3>

        <p style="font-size:1em; margin-bottom:1em; color:#000000;">
            We promise to only send this email update if you do not visit the site for 7 days, but if you wish to no longer receive these emails at all, just <a href="http://www.recordingquestions.com/login">sign into your account</a> and visit the settings tab in your profile.
        </p>

        <p style="font-weight:bold; color:#245876;">Best Regards,<br/><span>~ Team Recording Questions</span></p>

    </div>

</body>
</html>