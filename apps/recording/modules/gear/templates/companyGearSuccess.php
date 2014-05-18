<div id="content">

    <div id="main">

        <h1 class="title"><?php echo $company->getFullName() ?></h1>

        <div class="info">

            <p class="dates">

                <?php echo link_to('Gear', '@gear') ?> >
                <?php echo link_to($company->getFullName(), $company->getRoute()) ?> >
                Products
            </p>

        </div><!-- .info -->


        <div class="wrap-post company-post">

            <div class="post">

                    <p>
                        <?php echo image_tag($company->getLargeImagePath(), array('class' => 'gear-img', 'alt' => $company->getFullName().' company image')) ?>
                    </p>

                    <p>
                        <span class="point1">
                            <a href="#"><?php echo UserGearPeer::getUserCountByCompany($company->getId()) ?></a> people own gear from this company
                        </span>

                        <span class="point2">
                            <a href="#"><?php echo UserGearPeer::getUserCountByCompany($company->getId(), 'UserWants') ?></a> people want gear from this company
                        </span>
                    </p>

            </div><!-- .post -->


            <ul class="tags">

                <li class="title">Tag:</li>
                <li class="gear"><a href="#"><?php echo myUtil::slugify($company->getFullName()) ?></a></li>

            </ul>

        </div><!-- .wrap-post -->


        <?php include_component('gear', 'listGear',
                                    array(
                                        'title' => 'All Products',
                                        'gear_list' => GearPeer::getByCompany($company->getId(), $page, $results),
                                        'base_route' => 'gear_company_browse?company_name=' . myUtil::slugify($company->getFullName())
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