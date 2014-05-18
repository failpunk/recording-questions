<ul id="specs-tab-section" class="list-stats gear-stats">

    <li id="edit-specs-link">

        <p class="date1">Specs:</p>

        <p>
            <?php echo html_entity_decode($specs) ?>
        </p>

        <?php if($sf_user->isAuthenticated()): ?>
            <p class="edit-link"><a href="#">edit</a></p>
        <?php endif ?>

    </li>

</ul><!-- .list-stats -->

<?php if($sf_user->isAuthenticated()): ?>

    <form id="update-specs-section-form" class="comment">

        <div class="resizable-textarea">
            <span>
                <textarea class="textarea resizable processed" cols="5" rows="5" name="specstext" id="specs-section-text"><?php echo $specs ?></textarea>
                <div style="margin-right: -1px;" class="grippie"></div>
                <span class="error"></span>
            </span>
        </div>

        <p class="submit">
           <input type="submit" value="Submit" class="submit"/>
           <input id="cancel-specs-submit" type="submit" value="Cancel" class="submit cancel-a"/>
        </p>

        <?php echo input_hidden_tag('update-specs-route', url_for('@gear_update_specs')) ?>

    </form>
    
<?php endif ?>