<?php use_helper('custom') ?>

<div id="content">

    <?php if($sf_context->getUser()->hasCredential('admin')): ?>
        <div class="admin-controls">
            <span class="container">
                <?php echo link_to('Change Image', '@gear_update_image?type=company&for='.$company->getFullName().'&id=' . $company->getId()) ?>
            </span>
        </div>
    <?php endif ?>

    <div id="main" class="company-detail">

        <h1 class="title"><?php echo $company->getFullName() ?></h1>

        <p class="facebook-like-gear">
          <fb:like layout="button_count" width="50"></fb:like>
        </p>

        <?php if($sf_context->getUser()->isAuthenticated()): ?>
            <?php include_component('gear', 'flagPage', array('type' => 'company', 'key' => $company->getId())) ?>
        <?php endif ?>

        <div class="info">

            <p class="dates">
                <?php echo link_to('Gear', '@gear') ?> >
                <?php echo $company->getFullName() ?>
            </p>

            <?php if($company_info): ?>
            <p class="revision">
                last edit: <?php echo link_to($revision_user->getDisplayName(), html_entity_decode($revision_user->getRoute())) ?> <?php echo date_age_tag($company_info->getCreatedAt()) ?>
            </p>
            <?php endif ?>

        </div><!-- .info -->


        <div class="wrap-post company-post">

            <div class="post">

                    <p>
                        <?php if(file_exists(sfConfig::get('sf_web_dir') . '/images/' . $company->getLargeImagePath())): ?>
                            <?php echo image_tag($company->getLargeImagePath(), array('class' => 'gear-img', 'alt' => $company->getFullName().' gear image')) ?>
                        <?php else: ?>
                           <?php echo link_to('Upload an Image for '.$company->getFullName(), '@gear_update_image?type=company&for='.$company->getFullName().'&id=' . $company->getId()) ?>
                        <?php endif ?>
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

        <?php include_component('gear', 'companyAbout', array('company' => $company, 'company_info' => $company_info)) ?>

        <?php include_component('gear', 'companyProducts', array('company' => $company, 'title' => 'Other Products By '.$company->getFullName())) ?>

        <div class="head-tabs">

            <h3>Related Questions</h3>

        </div>

        <?php include_component('gear', 'gearRelatedQuestions', array('object' => $company, 'base_route' => $company->getRoute())) ?>

    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('gear', 'recentActivity') ?>

        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_partial('index/googleAds', array('unit' => 'shopping')) ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->