<div class="head-tabs">

    <h3><?php echo $title ?></h3>

</div><!-- .head-tabs -->

<div class="company-products">

    <ul>

        <?php foreach($products as $i => $gear): ?>
        <li>

            <a title="<?php echo $gear->getName() ?>" href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>">
                <span class="image">
                    <?php echo image_tag($gear->getSmallImagePath(), array('alt' => $gear->getName().' gear image')) ?>
                </span>
                
                <span><?php echo $gear->getName() ?></span>
            </a>

        </li>

        <?php if($i == 5) {break;} ?>
        <?php endforeach ?>

    </ul>

    <div style="clear:both;"></div>

    <?php if(count($products) > 6): ?>
    <p class="right">
        <a href="<?php echo url_for('@gear_company_browse?company_name='.myUtil::slugify($company->getFullName())) ?>">See all products from <?php echo $company->getFullName() ?> &raquo</a>
    </p>
    <?php endif ?>

</div>