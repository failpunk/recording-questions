<?php
/* 
 * Displays any comments for the Question Detail page
 */

if(!isset($limitComment)) {
    $limitComment = false;
}

$commentCount = count($comments) - sfConfig::get('app_comments_to_display');

$status       = ($limitComment) ? 'close' : 'open';
$linkClass    = ($limitComment) ? 'show-comments' : 'show-comments expanded';
$linkText     = ($limitComment) ? "Show Additional Comments ($commentCount)" : 'Hide Additional Comments';

?>

<ul class="comments">

    <?php foreach ($comments as $key => $comment): ?>
    
        <li>
            <p><?php echo html_entity_decode($comment->getDescription()) ?></p>
            <p class="info-user">
                <a href="<?php echo url_for('@authorProfile?userId='.$comment->getUser()->getId()) ?>"><?php echo $comment->getUser()->getDisplayName() ?></a>
                | <?php echo $comment->getCreatedAt('M d') ?> at <?php echo $comment->getCreatedAt('h:m') ?>
                <?php if($comment->getUser()->getId() == $sf_user->getCurrentUser()->getId() || $sf_user->hasCredential('admin')): ?>
                    | <?php echo link_to("delete comment",
                                         "@comment_delete?type=$type&comment_id=".$comment->getId(),
                                         array(
                                            "confirm" => "Are you sure you want to delete this comment?",
                                            "title" => "Delete this Comment"
                                         )); ?>
                <?php endif ?>
            </p>
        </li>

        <?php // Limit the number of comments shown if $limitComments is passed in ?>
        <?php if($limitComment): ?>
            <?php if($key + 1 == sfConfig::get('app_comments_to_display'))  break; ?>
         <?php endif ?>

    <?php endforeach; ?>
    
</ul><!-- .comments -->

<?php if($commentCount > 0): ?>

    <?php if(!isset ($questionId)): ?>
        <?php $questionId = null ?>
    <?php endif ?>

    <?php echo jq_link_to_remote($linkText,
        array(
                'update'   => $type.'Comments'.$id,
                'url'      => 'question/show'.ucfirst($type).'Comment?'.$type.'_id='.$id.'&question_id='.$questionId.'&status=' . $status,
             ),
        array(
                'class' => $linkClass
             )
    ) ?>
    
<?php endif ?>