<div class="head-tabs">

    <h3>About</h3>

</div><!-- .head-tabs -->

<ul id="company-about-info" class="list-stats gear-stats">

    <li>

        <p class="date1">Website:</p>

        <p class="company-about-website">

            <?php // Display link to add info if there is none ?>
            <?php if(!$company_info): ?>
                <span>
                <?php if($sf_user->isAuthenticated()): ?>
                    <a id="be-the-first" class="edit-link" href="#">Be the first to add info about <?php echo $company->getFullName() ?></a>
                <?php else: ?>
                    <a class="edit-link" href="<?php echo url_for('@login') ?>">Be the first to add info about <?php echo $company->getFullName() ?></a>
                <?php endif ?>
                </span>
            <?php else: ?>

                <a id="company-about-info-url" href="<?php echo $website ?>" rel="nofollow"><?php echo $website ?></a>&nbsp;

            <?php endif ?>
            
        </p>

        <?php if($sf_user->isAuthenticated()): ?>
            <p class="edit-link"><a href="#">edit</a></p>
        <?php endif ?>

    </li>

    <li>

        <p class="date1">About:</p>

        <p id="company-about-info-about">
            <?php echo html_entity_decode($about) ?>&nbsp;
        </p>

    </li>


</ul><!-- .list-stats -->

<?php if($sf_user->isAuthenticated()): ?>

    <div id="company-about-edit" class="best-answer submission">

        <h4>Edit Info for <?php echo $company->getFullName() ?></h4>

        <div class="wrap-post">

            <form action="<?php echo url_for('@company_update_about') ?>" method="post" id="company-about-edit-form" class="comment">
            
                <h5>Website</h5>

                <p>
                    <?php echo input_tag('url', $website, array('class' => 'text')) ?>
                    <span class="error"></span>
                </p>

                <h5>About</h5>

                <!--
                <p>
                    <span class="right">Words Remaining <span>100</span></span>
                </p>
                -->

                <div class="resizable-textarea">
                    <span>
                        <textarea class="textarea resizable processed" id="abouttext" name="abouttext"><?php echo myUtil::textarea($about) ?></textarea>
                        <span class="error"></span>
                    </span>
                </div>

                <p class="submit">

                    <input type="submit" class="submit save" value="Submit"/>
                    <input type="submit" class="submit cancel" value="Cancel" id="site-review-cancel"/>
                    <span class="ajax-loader"><img alt="Ajax-loader" src="/images/ajax-loader.gif"/></span>

                </p>
                
                <?php echo input_hidden_tag('companyid', $company->getId()) ?>
                <?php echo input_hidden_tag('update-about-route', url_for('@company_update_about')) ?>
                
            </form>

        </div><!-- .wrap-post -->

    </div>

<?php endif ?>