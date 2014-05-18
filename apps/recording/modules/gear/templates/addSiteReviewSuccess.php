<li class="">

    <h4><?php echo link_to($review->getTitle(), $review->getUrl()) ?></h4>

    <p class="txt01">From <strong><?php echo $review->getDomainOnly() ?></strong> - <?php echo $review->getPublishedDate('M-d-Y') ?></p>

    <p>
        <?php echo $review->getSummary() ?>
    </p>

</li>