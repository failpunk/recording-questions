<?php decorate_with(false) ?>
<?php $feed = $sf_data->getRaw('feed') ?>
<?php echo $feed->asXml() ?>
