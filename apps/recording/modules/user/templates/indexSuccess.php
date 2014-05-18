<?php use_helper('Form', 'Gravatar', 'custom') ?>

<script type="text/javascript">

$(document).ready(function() {

    $("#userInput").focus();
    $("#userInput").typeWatch({ highlight: true, wait: 500, captureLength: -1, callback: filter });

    $('#usrbut').mousedown(function()
    {
        filter($('#userInput').val());
    });

    function filter(text) {

        $.post
        (
            '<?php echo url_for('@user_filter') ?>',
            { q: encodeURIComponent(text.toLowerCase()), nav: '<?php echo $nav ?>' },
            function(result) {
                $("#user-search-results").html(result);
            },
            "html"
        );
    }

});

</script>

<div id="content">

    <div id="main">

        <h1 class="title">Search For Users</h1>

        <p class="p2">Looking for someone you might know?  Want to see where you rank compared to others on the site?  Just start typing in a display name below and start narrowing down the list.</p>

        <form class="searchUsers" method="post" action="">

            <p class="fields">

                Search users:
                <input id="userInput" type="text" class="text" />

            </p>

        </form>

        <div class="head-tabs">

            <ul class="nav">

                <?php if($nav == null): ?>
                <li><?php echo link_to_active('Top Ranked' ,'@user_nav?nav=rank', 'active', true) ?></li>
               <?php else: ?>
                <li><?php echo link_to_active('Top Ranked' ,'@user_nav?nav=rank', 'active') ?></li>
               <?php endif; ?>
                <li><?php echo link_to_active('Oldest Users' ,'@user_nav?nav=oldest', 'active') ?></li>
                <li><?php echo link_to_active('Newest Users' ,'@user_nav?nav=newest','active') ?></li>

            </ul>

        </div><!-- .head-tabs -->

        <div id="user-search-results">
                    
            <?php echo include_partial('user/filteredUsers', array(
                                                                'users' => $users,
                                                                'nav' => $nav,
                                                                'no_results' => $no_results
            )) ?>

        </div>

    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('index', 'tips') ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->