<div id="content">

    <div id="main">

        <?php include_component('gear', 'listGear',
                                    array(
                                        'title' => $nice_category,
                                        'gear_list' => GearPeer::getByCategoryForList($category, $page, $results),
                                        'base_route' => 'gear_category?category_name=' . $category
                                    )
        ) ?>
        
    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('gear', 'recentActivity') ?>

        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_partial('index/googleAds', array('unit' => 'shopping')) ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->