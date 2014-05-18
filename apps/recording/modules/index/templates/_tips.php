<div id="websiteTips">

    <?php $tip = $sf_data->getRaw('tip') ?>

    <h3><?php echo $tip->getTitle() ?></h3>

    <h4><?php echo $tip->getDescription() ?></h4>

    <?php echo $tip->getBody() ?>

</div><!-- #recentUsers -->