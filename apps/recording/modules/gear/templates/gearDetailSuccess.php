<?php use_helper('custom') ?>

<?php if($show_review): ?>

<script type="text/javascript">
    $().ready(function()
    {
        $('#reviews-tab').click();
    });
</script>

<?php endif ?>

<div id="content">

    <?php if($sf_context->getUser()->hasCredential('admin')): ?>
        <div class="admin-controls">
            <span class="container">

                <?php echo link_to('Change Image', '@gear_update_image?type=gear&for='.myUtil::slugify($gear->getName()).'&id=' . $gear->getId()) ?> |

                <?php if($sf_user->getAttribute('show_affiliate', false)): ?>
                    <?php echo link_to('Hide Affiliate', '@gear_toggle_affiliate?redirect=' . url_for($sf_request->getUri())) ?>
                <?php else: ?>
                    <?php echo link_to('Show Affiliate', '@gear_toggle_affiliate?redirect=' . url_for($sf_request->getUri())) ?>
                <?php endif ?>
                
            </span>
        </div>
    <?php endif ?>

    <div id="main" class="gear-detail">

        <?php echo include_component(
                        'gear',
                        'gearDetail',
                        array(
                            'gear' => $gear,
                            'company' => $company,
                            'gear_info' => $gear_info,
                            'revision_user' => $revision_user,
                            'added_to_studio' => $added_to_studio,
                            'ownership' => $ownership,
                        )
        ) ?>

        <?php include_component(
                        'gear',
                        'gearInfo',
                        array(
                            'gear' => $gear,
                            'gear_info' => $gear_info,
                            'company' => $company
                        )) ?>
        
        <div id="related-info">

            <?php include_component('gear', 'productMembers', array('gear' => $gear)) ?>

            <?php include_component('gear', 'companyProducts', array('title' => 'Other Products by ' . $company->getFullName(), 'company' => $gear->getGearCompany())) ?>

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

        <?php include_component('gear', 'recentActivity') ?>

        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

        <?php include_partial('index/googleAds', array('unit' => 'shopping')) ?>
        
    </div><!-- / #sidebar -->

</div><!-- / #content -->