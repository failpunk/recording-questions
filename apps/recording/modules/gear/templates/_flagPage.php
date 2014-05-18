<!-- Flag Gear -->
<p class="flag-gear">
    <a href="#" class="flag-post">Flag This</a>
</p>

<div id="flag-gear-page-options" class="small-alert" style="display: none;">

    <p><strong>Why are you flagging this page?</strong></p>

    <ul>

        <li><a href="#">This page is a duplicate entry</a></li>
        <li><a href="#">The image does not match page</a></li>
        <li><a href="#">It is spam</a></li>
        <li><a href="#">This is a copywrite infringement</a></li>
        <li><a href="#">The Buy Now link is not correct</a></li>

    </ul>

    <span id="question-lock-duplicate" style="display: none;">
        Enter the id # of the duplicate question:
        <?php echo input_tag('question-lock-duplicate-id') ?>
        <a href="#">submit</a>
    </span>

    <?php echo input_hidden_tag('flag-gear-page-route', url_for('@gear_flag_page')) ?>
    <?php echo input_hidden_tag('flag-gear-page-key', $key) ?>
    <?php echo input_hidden_tag('flag-gear-page-type', $type) ?>

    <p class="close"><a onclick="xhide('flag-gear-page-options');">X</a></p>

</div>