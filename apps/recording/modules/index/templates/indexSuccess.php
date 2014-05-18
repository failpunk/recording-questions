<?php use_helper('Form', 'Gravatar', 'custom') ?>


<div id="content">

    <div id="top">

            <h2>Got recording questions?</h2>

            <p id="subTitle">Get the best answers from thousands of experts online!</p>

            <?php echo form_tag("index/search", array('method' => 'get', 'class' => 'search', 'id' => 'search')) ?>

                <p class="fields">

                    <input name="search" id="searchField" type="text" class="text" value="Search for questions right here..." onfocus="this.value='';"	onblur="if(!this.value)this.value='Search for questions right here...';" />

                    <input type="image" src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/bt_searchHome.gif" value="Search"></input>

                </p>

            </form>

            <p>or <a href="<?php echo url_for('@ask_question') ?>">Submit your own question</a></p>

    </div><!-- #top -->

    <!-- <div id="alertTop" class="popup one">

            <h4>Congratulations! You have earned <strong>1</strong> experience point.</h4>

            <p>You have earned <strong>1</strong> additional experience point. Amet auctor, ligula porta ultrices nunc. Sem eu vestibuahsq <a href="#">honcus curab</a> itur temporlur temp.</p>

            <p class="close"><a href="#">X</a></p>

    </div>
     -->
    <!-- .popup -->

    <div id="main">

        <div class="head-tabs">

            <?php if($nav == null): ?>
                <?php $nav = "recent" ?>
            <?php endif; ?>

            <h3 class="feed"><?php echo getLableNavigation($nav) ?></h3>

            <p class="rss-title"><?php echo link_to("Rss", '@rss_for_question_list?nav='.$nav, array('class' => 'rss')) ?></p>

            <ul class="nav">

               <?php if($nav == "recent"): ?>
                <li><?php echo link_to_active('Recent' ,'@homepage_nav?nav=recent', 'active', true) ?></li>
               <?php else: ?>
                <li><?php echo link_to_active('Recent' ,'@homepage_nav?nav=recent', 'active') ?></li>
               <?php endif; ?>
                <li><?php echo link_to_active('Popular' ,'@homepage_nav?nav=popular','active') ?></li>
                <li><?php echo link_to_active('Last Week' ,'@homepage_nav?nav=lastWeek', 'active') ?></li>
                <li><?php echo link_to_active('Last Month' ,'@homepage_nav?nav=lastMonth', 'active') ?></li>
                <li><?php echo link_to_active('Unanswered' ,'@homepage_nav?nav=unanswered', 'active') ?></li>

                <?php if($sf_context->getUser()->hasCredential('admin')): ?>
                <li><?php echo link_to_active('deleted Questions' ,'@homepage_nav?nav=delete', 'active') ?></li>
                <li><?php echo link_to_active('deleted Answers' ,'@deleted_answers?nav=deleteAnswer', 'active') ?></li>
                <?php endif; ?>

            </ul>

        </div><!-- .head-tabs -->

        <?php echo include_component(
                            'question',
                            'questionList',
                            array(
                                'questions' => $questions,
                                'nav' => $nav
                            )
        ) ?>


    </div><!-- / #main -->

    <div id="sidebar">

        <?php include_component('index', 'tshirts') ?>

        <?php include_component('index', 'recentAnswers') ?>

        <?php include_component('gear', 'recentActivity') ?>

        <?php include_partial('index/googleAds') ?>

        <?php include_component('index', 'tips') ?>

        <?php include_component('user', 'recentUsers') ?>

        <?php include_component('index', 'tagCloud') ?>

    </div><!-- / #sidebar -->

    
</div><!-- / #content -->