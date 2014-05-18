<?php if(sfConfig::get('app_gear_enable') || myUtil::isGearBeta()): ?>

<ul class="tags">

    <li class="title">Tags:</li>

    <?php foreach ($tags as $tag):  ?>

        <?php if(!is_null($tag['GearTag.GearId'])): ?>

            <li class="gear"><?php echo link_to($tag['Tag.Name'], '@gear_link_gear?gear_id='.$tag['GearTag.GearId'], array('title' => 'Learn more about this piece of gear')) ?></li>

        <?php elseif(!is_null($tag['GearCompanyTag.CompanyId'])): ?>

            <li class="gear"><?php echo link_to($tag['Tag.Name'], '@gear_link_company?company_id='.$tag['GearCompanyTag.CompanyId'], array('title' => 'Check out the '.$tag['Tag.Name'].' company profile')) ?></li>

        <?php else: ?>

            <li><?php echo link_to($tag['Tag.Name'], '@searchByTag?tag='.$tag['Tag.Name'], array('title' => 'Search for questions with the tag '.$tag['Tag.Name'])) ?></li>

        <?php endif ?>
        
    <?php endforeach; ?>
    
</ul>


    <?php else: ?>  <?php //TODO: Justin - REMOVE THIS WHEN GEAR SECTION IS ENABLED ?>


<ul class="tags">
    <li class="title">Tags:</li>
    <?php foreach ($question->getTags() as $tag):  ?>
    <li><?php echo link_to($tag, '@searchByTag?tag='.$tag) ?></li>
    <?php endforeach; ?>
</ul>

<?php endif ?>