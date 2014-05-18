<?php use_helper('Form', 'Gravatar', 'custom') ?>


        <div id="content">

            <div id="top">

                <h2>Got recording questions?</h2>

                <p id="subTitle">Get the best answers from thousands of experts online!</p>

                <?php echo form_tag("@search", array('method' => 'get', 'class' => 'search', 'id' => 'search')) ?>
                    <p class="fields">

                        <input name="search" id="searchField" type="text" class="text" value="Search for questions right here..." onfocus="this.value='';"  onblur="if(!this.value)this.value='Search for questions right here...';" />

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

                <?php echo include_component('question', 'questionList', array(
                                                                            'questions' => $questions,
                                                                            'base_route' => 'searchByTagPerPage?tag=' . $tag
                                            )) ?>

            </div><!-- / #main -->

            <div id="sidebar">

                <?php include_component('index', 'recentAnswers') ?>

                <?php include_component('gear', 'recentActivity') ?>

                <?php include_partial('index/googleAds') ?>

                <?php include_component('user', 'recentUsers') ?>

                <?php include_component('index', 'tagCloud') ?>
            </div><!-- / #sidebar -->

        </div><!-- / #content -->