<?php use_helper('jQuery'); ?>

<?php if($status): ?>
    <?php if($status == 'positiv'): ?>
    <?php echo jq_link_to_remote("Favorite",
                        array(
                                'update'   => 'favorite_zone'.$question_id,
                                'url'      => 'profile/favoriteQuestion?question_id='.$question_id
                             ),
                        array(
                                'class' => 'favorite',
                                'title' => 'Click to add question to your favorites list, click again to remove.'
                             )
    ) ?>
    <?php else: ?>
    <?php echo jq_link_to_remote("Favorite",
                        array(
                                'update'   => 'favorite_zone'.$question_id,
                                'url'      => 'profile/favoriteQuestion?question_id='.$question_id
                             ),
                        array(
                                'class' => 'favorite2',
                                'title' => 'Click to add question to your favorites list, click again to remove.'
                             )
    ) ?>
    <?php endif; ?>

    <span class="count"><?php echo UserFavoritePeer::getFavoriteCountByQuestionId($question_id) ?></span>

<?php endif; ?>