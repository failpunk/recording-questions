<div class="head-tabs">

    <h3><?php echo $title ?></h3>

</div><!-- .head-tabs -->
<?php use_helper('custom') ?>

<ol id="searchResults" class="gear-results">

    <?php foreach($company_list->getResults() as $company): ?>
    <li>

        <h4><?php echo link_to($company->getFullName(), html_entity_decode($company->getRoute())) ?></h4>

        <p class="avatar">
            <a href="<?php echo url_for(html_entity_decode($company->getRoute())) ?>">
                <span class="image">
                    <?php echo image_tag($company->getSmallImagePath(), array('alt' => $company->getFullName().' company image')) ?>
                </span>
            </a>
        </p>

        <p>
            <?php //echo substr(strip_tags($company->getAbout()), 0, sfConfig::get('app_question_description_length')) ?>
        </p>

        <p class="info">
            viewed <a href="#" class="times"><strong>0</strong> times</a> |
            <?php echo date_age_tag($company->getCreatedAt()) ?>
        </p>

        <ul class="tags">
            <li class="title">Tag:</li>
            <li class="gear"><a href="#"><?php echo $company->getTagName() ?></a></li>
        </ul>

    </li>
    <?php endforeach ?>

</ol>

<?php include_component('index', 'pagination', array('pager' => $company_list, 'route' => 'gear_companies')) ?>