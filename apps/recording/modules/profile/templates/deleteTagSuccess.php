<?php use_helper('Form', 'jQuery'); ?>
<?php foreach ($tags as $tag): ?>
    <li><span class="delete">
    <?php echo jq_link_to_remote('delete', array(
                                'update' => $act.'Tags',
                                'url'    => 'profile/deleteTag?tagId='.$tag->getTag()->getId().'&act='.$act
    )) ?>
    </span><a href="#"><?php echo $tag->getTag()->getName() ?></a></li>
<?php endforeach; ?>


