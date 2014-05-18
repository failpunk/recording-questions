<?php use_helper('Tags') ?>
<div id="tagcloud">
    <h3>Tagcloud</h3>
        <?php echo tag_cloud($sf_data->getRaw('tags'), '@searchByTag?tag=%s');  ?>
</div><!-- #tagcloud -->