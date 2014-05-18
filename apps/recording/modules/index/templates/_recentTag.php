<?php use_helper('Form', 'jQuery'); ?>

<?php $session_user = $sf_context->getUser(); ?>



<div id="recentTags">

    <h3>Recent Tags</h3>

    <ul>
        <?php foreach ($sf_data->getRaw('recentTag') as $tag): ?>
        <li>

            <?php echo link_to($tag['tags'], '@searchByTag?tag='.$tag['tags']) ?>
            <?php if($session_user->isAuthenticated() && $session_user->hasCredential('user')): ?>

            <span id="<?php echo $tag['tags'] ?>">

                <span class="add">

                    <?php echo jq_link_to_remote('+',
                            array(
                                'update' => $tag['tags'],
                                'url'    => '@recent_tag?tag='.$tag['tags'].'&act=add'
                            ),
                            array(
                                 'class' => ((isset($tag['act']) && $tag['act']) ? 'active' : '')
                            )
                    )?>

                </span>
                
                <span class="sub">

                     <?php echo jq_link_to_remote('-',
                            array(
                                  'update' => $tag['tags'],
                                  'url'    => '@recent_tag?tag='.$tag['tags'].'&act=sub'
                            ),
                            array(
                                 'class' => isset($tag['act']) ? ((isset($tag['act']) && $tag['act']) ? '' : 'active') : ''
                            )
                     )?>

                </span>

            </span>

            <?php else: ?>
                <span class="add"><a>+</a></span>
                <span class="sub"><a>-</a></span>
            <?php endif; ?>

        </li>
        <?php endforeach; ?>

    </ul>

    <p class="right">
        <?php echo link_to('More tags &raquo', '@profile_settings', array('rel' =>  'nofollow')) ?>
    </p>

</div><!-- #recentTags -->