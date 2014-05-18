<div id="content">

    <div id="main" class="add-gear">

        <h1 class="title">Help Keep Things Up To Date</h1>

        <div class="info">

            <p class="dates">

                <?php echo link_to('Gear', '@gear') ?> >
                Add New

            </p>

        </div><!-- .info -->

        <p class="p2">We're trying to build the best and most up-to-date recording gear database on the web, and we need your help to keep things fresh.  If you can't find a piece of recording gear, simply add it here with as much info as you can.</p>

        <h4>What would you like to add?</h4>

        <?php echo select_tag('type', options_for_select(array(
          'Gear'    => 'Gear',
          'Company' => 'Company',
        ), $add_type)) ?>

        <div id="gear-div" style="<?php echo $display_gear ?>">

            <?php echo form_tag('@gear_add_to_db', array('id' => 'gear-add-to-db-form', 'class' => 'comment')) ?>

                <div class="step-1">
                    <h4>Gear Type</h4>
                    <?php echo select_tag('gear-type', options_for_select(StudioCategories::getStudioArray())) ?>
                </div>

                <div class="step-2">
                    <h4>Company Name</h4>
                    <input type="text" id="company" class="text ac_input company-complete" autocomplete="off" value="Start typing here..." name="company"/>
                    <p class="txt01">Select the company that makes this piece of gear (Digidesign, M-Audio)</p>
                    <span class="error"></span>
                </div>

                <div class="step-3">
                    <h4>Gear Name</h4>
                    <input type="text" id="gearname" class="text ac_input" autocomplete="off" value="Start typing here..." name="gear"/>
                    <p class="txt01">Enter the name of the piece of gear you would like to add (Mbox 2, FastTrack)</p>
                    <span class="error"></span>
                </div>

                <div class="step-4">
                    <p>Double check the information above and <a id="continue-gear-add" href="#">click here to continue</a></p>
                    <?php //echo submit_tag("Submit This Gear", array('type' => 'submit', 'class' => 'submit')) ?>
                </div>

                <div class="step-5">

                    <h4>About this Gear</h4>
                    <p>
                        <span class="right">Max Words <span>200</span></span>
                    </p>
                    <div class="resizable-textarea">
                        <span>
                            <?php echo textarea_tag('about-gear', '', array('class' => 'textarea resizable processed')) ?>
                            <span style="display:block;" class="error"></span>
                        </span>
                    </div>

                    <h4>Upload an Image</h4>

                    <p class="">
                        Search the web for the image you want to upload, right click and copy the image location, paste that URL into the text box below and hit the upload image link.
                        If everything looks ok, submit the image and you're done!<br/>
                        Just Remember...
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            We can handle JPG, PNG, or GIF images.
                            <span>(please keep files under 500 KB in size)</span>
                        </span>
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            Use the largest possible image, they will be scaled to 1024 x 768 pixels.
                        </span>
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            Make sure to only upload license-free images.
                        </span>
                    </p><br/>

                    <div id="image-upload">
                        <input type="text" id="urlimage" class="text" autocomplete="off" value="" name="urlimage"/>
                        <a class="upload-image" href="#">Upload Image</a>
                        <p class="txt01">Enter the URL of an image on the web</p>
                        <p><span class="ajax-loader"><img src="/images/ajax-loader.gif" alt="Ajax-loader"/></span></p>
                        <p class="error"></p>
                    </div>
                    
                    <?php echo input_hidden_tag('upload-image-file-name', '', array('class' => 'image-file-name')) ?>

                </div>

                <?php echo submit_tag("Submit New Gear", array('type' => 'submit', 'class' => 'submit', 'id' => 'submit_gear_button')) ?>

           </form>

        </div>

        <div id="company-div" style="<?php echo $display_company ?>">

            <?php echo form_tag('@company_add_to_db', array('id' => 'company-add-to-db-form', 'class' => 'comment')) ?>

                <div class="step-2">
                    <h4>Company Name</h4>
                    <input type="text" id="company" class="text ac_input company-complete" autocomplete="off" value="Start typing here..." name="company"/>
                    <p class="txt01">Add a new gear company</p>
                    <span class="error"></span>
                </div>

                <div class="step-3">

                    <h4>Company Website</h4>
                    <?php echo input_tag('website', 'http://', array('class' => 'text')) ?>
                    <p class="txt01">Add the official website for this company</p>
                    <span class="error"></span>

                    <h4>About this Company</h4>
                    <p>
                        <span class="right">Max Words <span>200</span></span>
                    </p>
                    <div class="resizable-textarea">
                        <span>
                            <?php echo textarea_tag('about-company', '', array('class' => 'textarea resizable processed')) ?>
                            <span style="display:block;" class="error"></span>
                        </span>
                    </div>

                    <h4>Upload a Company Logo</h4>

                    <p class="">
                        Search the web for the image you want to upload, right click and copy the image location, paste that URL into the text box below and hit the upload image link.
                        If everything looks ok, submit the image and you're done!<br/>
                        Just Remember...
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            We can handle JPG, PNG, or GIF images.
                            <span>(please keep files under 500 KB in size)</span>
                        </span>
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            Use the largest possible image, they will be scaled to 1024 x 768 pixels.
                        </span>
                    </p>

                    <p style="margin-bottom: .3em;">
                        <span class="point1">
                            Make sure to only upload license-free images.
                        </span>
                    </p><br/>

                    <div id="image-upload">
                        <input type="text" id="urlimage" class="text" autocomplete="off" value="" name="urlimage"/>
                        <a class="upload-image" href="#">Upload Image</a>
                        <p class="txt01">Enter the URL of an image on the web</p>
                        <p><span class="ajax-loader"><img src="/images/ajax-loader.gif" alt="Ajax-loader"/></span></p>
                        <p class="error"></p>
                    </div>
                    
                    <?php echo input_hidden_tag('upload-image-file-name', '', array('class' => 'image-file-name')) ?>
                    
                    <?php echo submit_tag("Submit New Company", array('type' => 'submit', 'class' => 'submit', 'id' => 'submit_company_button')) ?>

                </div>

            </form>

        </div>

    </div><!-- / #main -->
    
    <?php echo input_hidden_tag('find-company-route', url_for('@gear_find_company')) ?>
    <?php echo input_hidden_tag('find-gear-route', url_for('@gear_find_gear')) ?>
    <?php echo input_hidden_tag('upload-file-route', url_for('@gear_upload_image')) ?>

    
    <div id="sidebar">

        <?php include_component('gear', 'companies') ?>

        <?php include_component('gear', 'categories') ?>

    </div><!-- / #sidebar -->

</div<!-- / #content -->