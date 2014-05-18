<?php use_helper('jQuery'); ?>
<span class="add">
		<?php echo jq_link_to_remote('+',
			array(
			'update' => $tag,
			'url'    => '@recent_tag?tag='.$tag.'&act=add'
		    ),
		    array(
		    'class' => $act ? 'active' : ''
		    )
		)?>
</span>

<span class="sub">
        <?php echo jq_link_to_remote('-',
            array(
            'update' => $tag,
            'url'    => '@recent_tag?tag='.$tag.'&act=sub'
            ),
            array(
            'class' => $act ? '' : 'active'
            )
         )?>
</span>