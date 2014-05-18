<div id="content">

    <div id="main" class="gear">

        <h1 class="title">Find Recording Gear</h1>

        <div class="info">

            <p class="dates">

                <a href="#">Gear</a> >
                Browse

            </p>

            <p class="votes">

                <?php if($sf_user->isAuthenticated()): ?>
                    <?php $add_gear_route = '@gear_add_new?add_type=Gear' ?>
                <?php else: ?>
                    <?php $add_gear_route = '@login' ?>
                <?php endif ?>

                <span class="add">
                    <a href="<?php echo url_for($add_gear_route) ?>" class="vote" title="">+</a>
                </span>

                <?php echo link_to('Add New Gear!', $add_gear_route) ?>

            </p>

        </div><!-- .info -->


        <?php include_component('gear', 'listGear',
                                    array(
                                        'title' => 'Newest Gear',
                                        'gear_list' => GearPeer::getNewestForList($page, $results)
                                    )
        ) ?>


    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('gear', 'recentActivity') ?>

        <?php if($sf_user->isAuthenticated()): ?>
            <?php include_component('gear', 'leaderBoard') ?>
        <?php endif ?>
        
        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_component('index', 'recentAnswers') ?>

        <?php include_partial('index/googleAds') ?>

        <?php include_component('index', 'tshirts') ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->