<?php use_helper('jQuery', 'tooltips'); ?>

    <?php echo dispalay_tooltip("FavoritesAdd", '');  ?>

<p class="action" id="favorite_zone">

<span><?php echo UserFavoritePeer::getFavoriteCountByQuestionId($question_id) ?></span>

<?php if($status): ?>
    <?php if($status == 'positiv'): ?>
    <?php echo jq_link_to_remote("Favorite",
                        array(
                                'update'   => 'favorite-container',
                                'url'      => 'question/favoriteQuestion?question_id='.$question_id
                             ),
                        array(
                                'class' => 'favorite',
                                'title' => 'Click to add question to your favorites list, click again to remove.'
                             )
    ) ?>
    <?php else: ?>
    <?php echo jq_link_to_remote("Favorite",
                        array(
                                'update'   => 'favorite-container',
                                'url'      => 'question/favoriteQuestion?question_id='.$question_id
                             ),
                        array(
                                'class' => 'favorite2',
                                'title' => 'Click to add question to your favorites list, click again to remove.'
                             )
    ) ?>
    <?php endif; ?>
<?php endif; ?>
<a class="rss2" href="#" title="Follow this question in your favorite RSS reader">Rss</a>

</p>