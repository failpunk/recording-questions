<?php use_helper('custom') ?>


<div class="head-tabs">

    <h3><?php echo $user->getDisplayName() ?>'s Studio</h3>

</div><!-- .head-tabs -->

<?php if(count($user_gear) == 0 && $user_id == $sf_context->getUser()->getCurrentUser()->getId()): ?>
    <div class="box-preview" style="margin-bottom: 0;">

        <p><strong>Welcome to your new Recording Questions personal studio!</strong></p>
        <p>Let other people know what gear you are currently running in your own studio.  Simply visit any gear page on the site and then click the star icon below "Add to Studio".</p>
        <p><?php echo link_to("Start adding gear now!", "@gear") ?></p>

    </div>
<?php endif ?>


<!-- Gear User Has -->
<ul class="list-stats studio">


    <?php echo include_partial('gear/studioPlatform', array('user' => $user)) ?>


    <?php foreach($studio as $field => $section): ?>
    <li>

        <p class="date1"><?php echo $section ?>:</p>

        <ul class="tags"> &nbsp;
        <?php $has_gear = false; ?>
        <?php foreach($user_gear as $gear): ?>

            <?php if(StudioCategories::getProperGroup($gear->getSection()) == $field && !$gear->getColumn('user_wants')): ?>

                <?php if($gear->getColumn('user_has')): ?>
                    <?php $class_name = 'gear' ?>
                <?php else: ?>
                    <?php $class_name = 'had-gear' ?>
                <?php endif ?>

                <li class="<?php echo $class_name ?>">
                    <a href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>" title=""><?php echo $gear->getTagName() ?></a>
                </li>
                <?php $has_gear = true; ?>

            <?php endif ?>

        <?php endforeach ?>

        <?php if(!$has_gear && $user_id == $sf_context->getUser()->getCurrentUser()->getId()): ?>
            <span><?php echo link_to("Add to your studio", '@gear_category?category_name='.$field) ?></span>
        <?php endif ?>
        </ul>

    </li>
    <?php endforeach ?>

</ul>


<!-- Gear User Wants -->
<h4>Gear <?php echo $user->getDisplayName() ?> Wants</h4>

<ul class="list-stats studio">

    <li>

        <p class="date1">Gear:</p>

        <ul class="tags"> &nbsp;
        <?php $wants_gear = false; ?>

            <?php foreach($user_gear as $gear): ?>

                <?php if($gear->getColumn('user_wants')): ?>

                    <li class="had-gear">
                        <a title="" href="<?php echo url_for(html_entity_decode($gear->getRoute())) ?>"><?php echo $gear->getTagName() ?></a>
                    </li>

                    <?php $wants_gear = true; ?>
                <?php endif ?>

            <?php endforeach ?>

        <?php if(!$wants_gear && $user_id == $sf_context->getUser()->getCurrentUser()->getId()): ?>
            <span><?php echo link_to("Add the gear you want", '@gear') ?></span>
        <?php endif ?>
        </ul>

    </li>

</ul>

