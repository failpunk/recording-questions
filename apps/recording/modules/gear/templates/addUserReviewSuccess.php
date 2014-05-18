<li class="">

    <h4><?php echo link_to($review->getTitle(), 'http://recordingquestions.com') ?></h4>

    <p class="txt01">
        By <strong><a href="<?php echo url_for('@authorProfile?userId='.$review->getUserId()) ?>"><?php echo UserPeer::retrieveByPK($review->getUserId())->getDisplayName() ?></a></strong> - <?php echo $review->getCreatedAt('M-d-Y') ?>
    </p>

    <p>
        <?php echo $review->getSummary() ?>
    </p>

</li>