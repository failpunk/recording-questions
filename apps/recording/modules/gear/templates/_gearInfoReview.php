<div id="reviews-tab-section">

    <ul id="site-review-section" class="list">

        <!-- Site Reviews -->
        <a id="new-site-review" class="new-site-review" style="float:right;" href="#">Add a New Link</a>

        <h3>Gear Review Sites</h3>

        <?php if($sf_context->getUser()->isAuthenticated()): ?>
        <li id="add-site-review" style="display:none;">

            <div class="best-answer submission">

                <h4>Add a New Review for <?php echo $gear->getName() ?></h4>

                <p>Share links to your favorite reviews from around the web for <?php echo $gear->getName() ?>.</p>

                <div class="wrap-post">

                    <?php echo form_tag('@gear_add_review_site', array('class' => 'comment', 'id' => 'add-site-review-form')) ?>

                        <h5>Review Url</h5>

                        <p>
                            <?php echo input_tag('url', '', array('class' => 'text')) ?>
                            <span class="error"></span>
                        </p>

                        <h5>Published Date <span>( MM/DD/YYYY )</span></h5>

                        <p>
                            <?php echo input_tag('date', '', array('class' => 'text')) ?>
                            <span class="error"></span>
                        </p>

                        <h5>Review Title</h5>

                        <p>
                            <?php echo input_tag('title', '', array('class' => 'text')) ?>
                            <span class="error"></span>
                        </p>

                        <h5>Summary</h5>

                        <p>
                            <span class="right">Words Remaining <span>100</span></span>

                            <div class="resizable-textarea">
                                <span>
                                    <?php echo textarea_tag('summary', '', array('class' => 'textarea resizable processed')) ?>
                                    <span class="error"></span>
                                </span>
                            </div>

                        </p>

                        <p class="submit">

                            <input type="submit" value="Submit" class="submit save"/>
                            <input id="site-review-cancel" type="submit" value="Cancel" class="submit cancel"/>
                            <span class="ajax-loader"><?php echo image_tag('ajax-loader.gif') ?></span>

                        </p>
                        <?php echo input_hidden_tag('gearid', $gear->getId()) ?>
                        <?php echo input_hidden_tag('add-site-review-route', url_for('@gear_add_review_site')) ?>

                    </form>

                </div><!-- .wrap-post -->

            </div>

        </li>
        <?php else: ?>
            <li id="add-site-review" style="display:none;">

                <div class="popup three" style="width:600px; margin-bottom:25px;">

                    <h4>You must be signed in to post a link.</h4>

                    <h4><a href="<?php echo url_for('@login') ?>">Sign In or Sign Up</a></h4>

                    <p class="close"><a href="#">X</a></p>

                </div>

            </li>
        <?php endif ?>

        <?php foreach($site_reviews as $review): ?>
            <li class="">

                <?php echo input_hidden_tag('review_id', $review->getId()) ?>

                <a class="flag-post" href="#">Flag this post</a>

                <h4>
                    <a href="<?php echo $review->getUrl() ?>"><?php echo $review->getTitle() ?></a>
                </h4>

                <p class="txt01">From <strong><?php echo $review->getDomainOnly() ?></strong> - <?php echo $review->getPublishedDate('M-d-Y') ?></p>

                <p>
                    <?php echo html_entity_decode($review->getSummary()) ?>
                </p>

            </li>
        <?php endforeach ?>

        <?php if(count($site_reviews) == 0): ?>
            <li class="no-review">

               <p><a class="new-site-review" href="#">Be the first to add a link to a review!</a></p>

            </li>
        <?php endif ?>

        <div class="divider"></div>

    </ul><!-- #site-review-section -->


    <ul id="user-review-section" class="list">

         <!-- User Reviews -->
        <a id="new-user-review" class="new-user-review" style="float:right;" href="#">Add Your Review</a>

        <h3>Gear User Reviews</h3>

        <?php if($sf_context->getUser()->isAuthenticated()): ?>
            <li id="add-user-review" style="display:none;">

                <div class="best-answer submission">

                    <h4>Add Your Own Review for <?php echo $gear->getName() ?></h4>

                    <p>Are you ready to add your own review?</p>

                    <div class="wrap-post">

                        <?php echo form_tag('@gear_add_review_user', array('class' => 'comment', 'id' => 'add-user-review-form')) ?>

                            <h5>Review Title</h5>

                            <p>
                                <?php echo input_tag('title', '', array('class' => 'text')) ?>
                                <span class="error"></span>
                            </p>

                            <h5>Summary</h5>

                            <p>
                                <span class="right">Max Words <span>50</span></span>

                                <div class="resizable-textarea">
                                    <span>
                                        <?php echo textarea_tag('summary', '', array('class' => 'textarea resizable processed')) ?>
                                        <span class="error"></span>
                                    </span>
                                </div>

                            </p>

                            <h5>Review</h5>

                            <p>
                                <span class="right">Min Words <span>100</span></span>

                                <div class="resizable-textarea">
                                    <span>
                                        <?php echo textarea_tag('review', '', array('class' => 'textarea resizable processed')) ?>
                                        <span class="error"></span>
                                    </span>
                                </div>

                            </p>

                            <p class="submit">

                                <input type="submit" value="Submit" class="submit save"/>
                                <input id="user-review-cancel" type="submit" value="Cancel" class="submit cancel"/>
                                <span class="ajax-loader"><?php echo image_tag('ajax-loader.gif') ?></span>

                            </p>
                            <?php echo input_hidden_tag('gearid', $gear->getId()) ?>
                            <?php echo input_hidden_tag('add-user-review-route', url_for('@gear_add_review_user')) ?>

                        </form>

                    </div><!-- .wrap-post -->

                </div>

            </li>
        <?php else: ?>
            <li id="add-user-review" style="display:none;">

                <div class="popup three" style="width:600px; margin-bottom:25px;">

                    <h4>You must be signed in to post a review.</h4>

                    <h4><a href="<?php echo url_for('@login') ?>">Sign In or Sign Up</a></h4>

                    <p class="close"><a href="#">X</a></p>

                </div>

            </li>
        <?php endif ?>

        <?php foreach($user_reviews as $review): ?>
            <li class="">

                <?php echo input_hidden_tag('review_id', $review->getId()) ?>

                <a class="flag-post" href="#">Flag this post</a>

                <h4><?php echo link_to($review->getTitle(), html_entity_decode($user_review_route . "&title=" . myUtil::slugify($review->getTitle())) . "&review_id=" . $review->getId()) ?></h4>

                <p class="txt01">
                    By <strong><a href="<?php echo url_for('@authorProfile?userId='.$review->getUserId()) ?>"><?php echo UserPeer::retrieveByPK($review->getUserId())->getDisplayName() ?></a></strong> - <?php echo $review->getCreatedAt('M-d-Y') ?>
                </p>

                <p>
                    <?php echo $review->getSummary() ?> 
                    <span>
                        - <?php echo link_to('Read More', html_entity_decode($review->getFullReviewRoute($gear->getName(), $gear->getGearCompany()->getName())), array('class' => 'review-read-more')) ?>
                    </span>
                </p>

            </li>
        <?php endforeach ?>

        <?php if(count($user_reviews) == 0): ?>
            <li class="no-review">

               <p><a class="new-user-review" href="#">Be the first to add your own review!</a></p>

            </li>
        <?php endif ?>

        <?php echo input_hidden_tag('add-offensive-route', url_for('@gear_add_offensive')) ?>

    </ul><!-- #user-review-section -->

</div>