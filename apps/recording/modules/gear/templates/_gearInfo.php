<div class="head-tabs">

    <h3 id="gear-section-title">About</h3>

    <ul id="gear-info" class="nav">
        <li><a id="about-tab" href="#" title="Sort answers by number of votes" class="active">About</a></li>
        <li><a id="specs-tab" href="#">Specs</a></li>
        <li><a id="reviews-tab" href="#">Reviews (<?php echo GearReviewPeer::getReviewCount($gear->getId()) ?>)</a></li>
        <li><a id="discuss-tab" href="#">Discuss</a></li>
    </ul>

</div><!-- .head-tabs -->

<div id="gear-info-div">

    <?php include_component('gear', 'gearInfoAbout', array('gear_info' => $gear_info)) ?>

    <?php include_component('gear', 'gearInfoSpecs', array('gear_info' => $gear_info)) ?>

    <?php include_component('gear', 'gearInfoReview', array('gear' => $gear)) ?>

    <div id="discuss-tab-section">

        <?php include_component('gear', 'gearRelatedQuestions', array(
                                                                'object' => $gear,
                                                                'title' => 'Related Questions',
                                                                'base_route' => $gear->getRoute()
                                                                     )) ?>
        
    </div>

</div>