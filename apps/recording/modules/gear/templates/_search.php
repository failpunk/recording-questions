<?php use_helper('Form', 'jQuery'); ?>

<script type="text/javascript">

    $().ready(function()
    {

        jQuery("#gearsearch").autocomplete("<?php echo url_for('@gear_search') ?>", {
            use_style: true
        }).result(function(event, formatted) {
            // redirect to the URL in the string
            var url = formatted[0].split('"');
//            alert(url);
            location.href = url[1].replace('"', '');
        });

        // remove directions from search box
        $('#gearsearch').focus(function()
        {
            if($(this).val() == "Start typing here...") {
                $(this).val("");
            }
        });

        // remove directions from search box
        $('#gearsearch').blur(function()
        {
            if($(this).val() == "") {
                $(this).val("Start typing here...");
            }
        });
    });

</script>

<div class="greenSidebar">

    <h3>Search For Gear</h3>

    <ul>

        <li>

           <input type="text" id="gearsearch" class="text ac_input" autocomplete="off" value="Start typing here..." name="gearsearch"/>
            
        </li>
        
    </ul>

    <p class="right">
        <a rel="nofollow" href="<?php echo url_for('@gear_add_new?add_type=Gear') ?>">Add a New Piece of Gear »</a>
    </p>

</div>