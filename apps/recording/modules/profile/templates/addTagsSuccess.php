<?php use_helper('Form', 'jQuery'); ?>

<?php if(isset($availablePositiveUserTag)): ?>
    <div class="popup one" style="width: 95%">
    <p>You already have this Favourite Tags:</p>
    <?php foreach ($availablePositiveUserTag as $availablePositiveTagItem): ?>
        <p><?php echo $availablePositiveTagItem->getTag()->getName() ?></p>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if(isset($availableNegativeUserTag)): ?>
    <div class="popup one" style="width: 95%">
    <p>You already have this Ignore Tags:</p>
    <?php foreach ($availableNegativeUserTag as $availableNegativeTagItem): ?>
        <p><?php echo $availableNegativeTagItem->getTag()->getName() ?></p>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php foreach ($tags as $tag): ?>
    <li><span class="delete">
    <?php echo jq_link_to_remote('delete', array(
                                'update' => $act.'Tags',
                                'url'    => 'profile/deleteTag?tagId='.$tag->getTag()->getId().'&act='.$act
    )) ?>
    </span><a href="#"><?php echo $tag->getTag()->getName() ?></a></li>
<?php endforeach; ?>
