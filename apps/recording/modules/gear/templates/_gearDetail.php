<h1 class="title"><?php echo $gear->getName() ?></h1>

<?php if($sf_context->getUser()->isAuthenticated()): ?>
    <?php include_component('gear', 'flagPage', array('type' => 'gear', 'key' => $gear->getId())) ?>
<?php endif ?>

<div class="info">

    <p class="dates">

        <?php echo link_to('Gear', '@gear') ?> >
        <?php echo link_to(ucwords($company->getFullName()), '@gear_company?company_name=' . myUtil::slugify($company->getFullName())) ?> >
        <?php echo $gear->getName() ?>

    </p>

    <?php if($gear_info): ?>
    <p class="revision">
        last edit: <?php echo link_to($revision_user->getDisplayName(), html_entity_decode($revision_user->getRoute())) ?> <?php echo date_age_tag($gear_info->getCreatedAt()) ?>
    </p>
    <?php endif ?>

<!--
    <p class="votes">

        <span class="sub"><a href="#">-</a></span>

        <span class="num">128</span>

        <span class="add"><a href="#">+</a></span>

    </p>
-->

</div><!-- .info -->


<div class="wrap-post gear-post">

    <div id="gear-post-tooltip" class="small-alert" style=" display:none; left:-175px; top:125px;">
        <p>You must join the community to add gear to your studio.<br/>
        </p><h4><?php echo link_to('Join Now!', '@login') ?></h4>
        <p class="close"><a onclick="xhide('gear-post-tooltip');">X</a></p>
    </div>

    <div id="add-to-profile-options" class="small-alert">

        <ul>

            <li><a href="#">You Own This</a></li>
            <li><a href="#">You Want This</a></li>

        </ul>

        <p class="close"><a onclick="xhide('add-to-profile-options');">X</a></p>

        <?php echo input_hidden_tag('add-to-profile-gear-id', $gear->getId()) ?>
        <?php echo input_hidden_tag('add-to-profile-route', url_for("@gear_add_to_studio")) ?>

    </div>

    <div class="post">

      <p class="avatar">

        <span class="point1"><a href="#"><?php echo UserGearPeer::getUserCountByGear($gear->getId()) ?></a> people own this</span>

        <span class="point2"><a href="#"><?php echo UserGearPeer::getUserCountByGear($gear->getId(), 'UserWants') ?></a> people want this</span>

      </p>

      <p class="add-to-profile">

        <strong>Add to Studio</strong>

        <a id="add-to-profile" href="#" class="<?php echo ($added_to_studio) ? 'favorite' : 'favorite2' ?>" title="Click to add this piece of gear to your studio, click again to remove">Add to profile</a>

        <span id="ownership-status">
                  <?php echo ((isset ($ownership)) ? $ownership : '') ?>
        </span>

      </p>

      <p class="facebook-like">
        <fb:like layout="button_count" width="50"></fb:like>
      </p>

      <p>
                <?php if(file_exists(sfConfig::get('sf_web_dir') . '/images/' . $gear->getLargeImagePath())): ?>
        <a class="largest-img" href="<?php echo url_for('@large_gear_image?image_name=' . $gear->getFullImagePath()) ?>">
                    <?php echo image_tag($gear->getLargeImagePath(), array('class' => 'gear-img', 'alt' => $gear->getName().' gear image', 'title' => 'Click to see a larger version')) ?>
        </a>
                <?php else: ?>
                  <?php echo link_to(
                  'Upload an Image of an '.$gear->getName(),
                  '@gear_update_image?type=gear&for='.$gear->getName().'&id=' . $gear->getId(),
                  array('rel' => 'nofollow')
                  ) ?>
                <?php endif ?>
      </p>

    </div><!-- .post -->


    <ul class="tags">

        <li class="title">Tag:</li>
        <li class="gear"><a href="#"><?php echo $gear->getTagName() ?></a></li>

        <?php if($affiliate_link): ?>

        <li class="buy-now">
            <a href="<?php echo url_for('@affiliate_link?description=' . $gear->getName() . '&id=' . $gear->getId()) ?>" title="Help support Recording Questions">

                <?php if($buy_now == 'Buy Now'): ?>

                    <span><?php echo $buy_now ?></span>
                    <p class="txt01">Musicians Friend ($<?php echo $affiliate_link['price'] ?>)</p>

                <?php else: ?>

                    <input type="submit" class="submit" value="<?php echo $buy_now ?>" name="commit"/>

                <?php endif ?>
               
            </a>

            <?php // display affiliate link info if enabled by admin ?>
            <?php if($sf_context->getUser()->hasCredential('admin') && $sf_user->getAttribute('show_affiliate', false)): ?>
                <p class="txt01"><?php echo $affiliate_link['name'] ?></p>
                <p class="txt01">sku: <?php echo $affiliate_link['sku'] ?></p>
            <?php endif ?>

            <?php // Only trigger imression in production ?>
            <?php if(sfConfig::get('sf_environment') == 'prod' && array_key_exists('impression_url', $affiliate_link)): ?>
                <img class="impression" src="<?php echo $affiliate_link['impression_url'] ?>" />
            <?php endif ?>
        </li>
        <?php endif ?>

    </ul>

    <?php echo input_hidden_tag('user-signed-in', ($sf_context->getUser()->isAuthenticated()) ? 'true' : 'false') ?>

</div><!-- .wrap-post -->