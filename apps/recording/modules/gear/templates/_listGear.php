<div class="head-tabs">

    <h3 class="feed"><?php echo $title ?></h3>

    <p class="rss-title">
        <?php echo link_to("rss", '@gear_rss', array('class' => 'rss', 'title' => 'Get all the latest gear in your rss reader')) ?>
    </p>

</div><!-- .head-tabs -->
<?php use_helper('custom') ?>

<ol id="searchResults" class="gear-results">
    
    <?php if($gear_list->getNbResults() == 0): ?>

        <li>
            <p>Sorry, we could not find any gear.</p>
        </li>

    <?php endif ?>

    <?php foreach($gear_list->getResults() as $gear): ?>
    <li>
                
        <h4>
            <?php echo link_to(ucwords($gear->getGearCompany()->getName() . ' ' . $gear->getName()), html_entity_decode($gear->getRoute())) ?>
        </h4>

        <p class="avatar">
            <a href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>">
                <span class="image">
                    <?php echo image_tag($gear->getSmallImagePath(), array('alt' => $gear->getName().' gear image')) ?>
                </span>
            </a>
        </p>

        <p>
            <?php //echo substr(strip_tags($gear->getAbout()), 0, sfConfig::get('app_question_description_length')) ?>
        </p>

        <p class="info">
            <a href="<?php echo url_for(html_entity_decode($gear->getRoute().'&reviews=yes')) ?>" class="times"><strong><?php echo $gear->getReviewCount() ?></strong> reviews</a> |
            updated <?php echo date_age_tag($gear->getCreatedAt()) ?> |

            <!--<a id="add-to-studio" href="#">Add to Your Studio</a>-->

        </p>

        <ul class="tags">
            <li class="title">Tag:</li>
            <li class="gear"><a href="#"><?php echo $gear->getTagName() ?></a></li>
        </ul>

        <?php if($sf_user->isAuthenticated()): ?>

            <ul class="tags add-gear">
            <?php $user_gear = UserGearPeer::retrieveByPK($user_id, $gear->getId()); ?>
            <?php if($user_gear && !$user_gear->getUserHad()): ?>
                <li><?php echo $user_gear->getOwnershipText(); ?></li>
            <?php else: ?>
                
                    <li><a class="add-to-studio" href="#">Add to Studio</a></li>
                    <li id="add-studio-options-li<?php echo $gear->getId() ?>" class="options" style="display: none;">
                        <span><a class="choice" href="#">You Own This</a></span>
                        <span><a class="choice" href="#">You Want This</a></span>
                        <span><a class="close" onclick="xhide('add-studio-options-li<?php echo $gear->getId() ?>');" title="click to close">X</a></span>
                    </li>
                
            <?php endif ?>
            </ul>

        <?php else: ?>
        
            <ul class="tags add-gear">

                <li class="not-authenticated"><a class="" href="<?php echo url_for('@login') ?>">Add to Studio</a></li>

            </ul>

        <?php endif ?>

        <div class="answvot-normal">

            <p class="answer"><a href="#"><span class="num"><?php echo UserGearPeer::getUserCountByGear($gear->getId()) ?></span>Have It</a></p>

            <p class="vot"><a href="#"><span class="num"><?php echo UserGearPeer::getUserCountByGear($gear->getId(), 'UserWants') ?></span>Want It</a></p>

        </div>

        <?php echo input_hidden_tag('gear_id', $gear->getId()) ?>

    </li>
    <?php endforeach ?>

    <?php echo input_hidden_tag('add-to-profile-route', url_for("@gear_add_to_studio")) ?>
</ol>

<?php include_component('index', 'pagination', array('pager' => $gear_list, 'route' => $base_route)) ?>