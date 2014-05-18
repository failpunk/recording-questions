<?php use_helper('custom') ?>

<div id="content">

    <h2 class="title">We couldn't find the page you were looking for...</h2>

    <p class="p4">
        We would suggest you try one of the following:
    </p>

    <ul class="p4">
        <li>Try using the search box above.</li>
        <li>Check out the most <?php echo link_to_active('Popular Questions' ,'@homepage_nav?nav=popular') ?></li>
        <li>Read the <?php echo link_to('Frequently Asked Questions' ,'@faq') ?></li>
    </ul>

    <p class="p4">
        If you really think we messed up...feel free to <?php echo mail_to('us@recordingquestions.com', 'contact us with your concerns', 'encode=true') ?>.
    </p>

    <form action="<?php echo url_for('index/index') ?>">
        <input type="submit" class="submit" value="Return To Homepage"/>
    </form>

    <div id="sidebar">

        <?php include_component('index', 'recentAnswers') ?>

        <?php include_component('gear', 'recentActivity') ?>

        <?php include_partial('index/googleAds') ?>

        <?php include_component('user', 'recentUsers') ?>

        <?php include_component('index', 'tagCloud') ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->