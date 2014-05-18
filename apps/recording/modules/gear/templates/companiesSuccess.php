<div id="content">

    <div id="main">

        <?php include_component('gear', 'listCompanies',
                                    array(
                                        'title' => 'All Companies'
                                    )
        ) ?>
        
    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_partial('index/googleAds', array('unit' => 'shopping')) ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->