<div class="blueSidebar studio-image">

    <h3>Studio Image</h3>

    <?php if(file_exists(sfConfig::get('sf_web_dir') . $user->getStudioImage())): ?>
        <?php echo image_tag($user->getStudioImage(), array('alt' => 'Picture of '.$user->getDisplayName().'\'s studio')) ?>
    <?php else: ?>
        <?php echo image_tag('/images/'.sfConfig::get('app_gear_studio_images').'/default-250.jpg', array('alt' => $user->getDisplayName().' has yet to add a picture of their studio')) ?>
    <?php endif ?>

    <?php if($user->getId() == $sf_user->getCurrentUser()->getId()): ?>
        <p class="align-r" style="margin-top:10px;">
            <a href="<?php echo url_for('@profile_edit_studio_image?user_id='.$user->getId()) ?>" rel="nofollow">Add an image of your studio</a>
        </p>
    <?php endif ?>

</div>