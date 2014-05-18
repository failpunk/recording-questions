<div id="content">

    <div id="main">

        <h1 class="title">Upload an image of your studio</h1>

        <p class="">
            Ready to upload a new image for a product or company?  Ok, it's simple! <br/>
            Search the web for the image you want to upload, right click and copy the image location, paste that URL into the text box below and hit the upload image link.  If everything looks ok, submit the image and you're done!<br/>
            Just Remember...
        </p>

        <p style="margin-bottom: .3em;">
            <span class="point1">
                We can handle JPG, PNG, or GIF images.
                <span>(keep files under 500 KB in size)</span>
            </span>
        </p>

        <p style="margin-bottom: .3em;">
            <span class="point1">
                All images will be resized to 250px in width.
            </span>
        </p>

        <p style="margin-bottom: .3em;">
            <span class="point1">
                Make sure to only upload license-free images.
            </span>
        </p>
        <br/>
            
        <h4>Upload an Image</h4>

        <div id="gear-div">

            <?php echo form_tag('@profile_edit_studio_image') ?>

                <div id="image-upload" class="updateImage">
                    <input type="text" id="urlimage" class="text" autocomplete="off" value="" name="urlimage"/>
                    <a class="upload-image" href="#">Upload Image</a>
                    <p class="txt01">Enter the URL of an image on the web</p>
                    <p><span class="ajax-loader" style="display:none;"><img src="/images/ajax-loader.gif" alt="Ajax-loader"/></span></p>
                    <p class="error"></p>
                </div>

                <?php echo input_hidden_tag('upload-image-file-name') ?>
                <?php echo input_hidden_tag('user_id', $user->getId()) ?>

                <?php echo submit_tag("Upload This Image", array('type' => 'submit', 'class' => 'submit', 'id' => 'submit_gear_button', 'style' => 'display:none;')) ?>

            </form>

        </div>

        <?php echo input_hidden_tag('upload-file-route', url_for('@gear_upload_image')) ?>

    </div><!-- / #main -->

    
    <div id="sidebar">

        <?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

        <?php include_partial('profile/studioImage', array('user' => $user)) ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->