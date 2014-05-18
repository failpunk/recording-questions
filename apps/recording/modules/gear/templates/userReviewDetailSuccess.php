<?php use_helper('Gravatar', 'custom') ?>

<div id="content">

    <div id="main" class="user-review">

        <?php echo include_component(
                        'gear',
                        'gearDetail',
                        array(
                            'gear' => $gear,
                            'company' => $company,
                            'gear_info' => $gear_info,
                            'revision_user' => $revision_user
                        )
        ) ?>


        <div class="head-tabs">

            <h3 id="gear-section-title">Reviews</h3>

            <ul class="nav" id="gear-info">
                <li><a title="Sort answers by number of votes" href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>" id="about-tab">About</a></li>
                <li><a href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>" id="specs-tab">Specs</a></li>
                <li><a class="active" href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>" id="reviews-tab">Reviews (3)</a></li>
                <li><a href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>" id="discuss-tab">Discuss</a></li>
            </ul>

        </div>

        <ul id="user-review-section" class="list">

            <li class="">

                <?php echo input_hidden_tag('review_id', $user_review->getId()) ?>

                <a class="flag-post" href="#">Flag this post</a>

                <div class="author-info">
                    <p class="avatar"><?php echo gravatar_image_tag($user->getEmail())?></p>

                    <p class="txt01">
                        <strong><a href="<?php echo url_for('@authorProfile?userId='.$user_review->getUserId()) ?>"><?php echo $user->getDisplayName() ?></a></strong> - <?php echo $user_review->getCreatedAt('M-d-Y') ?>
                    </p>
                </div>

                <h4><?php echo $user_review->getTitle() ?></h4>

                <p>
                    <?php echo html_entity_decode($user_review->getReview()) ?>
                </p>

            </li>

        </ul><!-- #user-review-section -->

        
        <div id="related-info">

            <?php if(sfConfig::get('app_ebay_enable')): ?>
                <div id="ebay-results-div">
                    <script type="text/javascript">
                        $.post
                        (
                            '<?php echo url_for('@gear_ebay_results') ?>',
                            {
                                gear_name: '<?php echo $gear->getName().' '.$company->getFullName() ?>'
                            },
                            function(result) {
                                     $("#ebay-results-div").html(result);
                            },
                            "html"
                        );
                    </script>
                </div>
            <?php else: ?>
                <span style="color:red;">Ebay Links Disabled</span>
            <?php endif ?>

        </div>

        <?php echo input_hidden_tag('gear_id', $gear->getId()) ?>

    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_partial('gear/search') ?>

        <?php include_component('gear', 'companies') ?>
        
        <?php include_component('gear', 'recentActivity') ?>

        <?php include_component('index', 'tagCloud') ?>

    </div><!-- / #sidebar -->

</div><!-- / #content -->