<?php use_helper('Form', 'Gravatar', 'custom', 'jQuery') ?>

		<div id="content">

			<div id="main">

				<h1 class="title"><strong>Favorite Questions for <?php echo ucfirst($user->getDisplayName()) ?></strong></h1>

				<!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

				<p class="p2">Have trouble remembering those great questions?  Just add them to your favorites section.  To add a question to your list below just click on the star next to the title on the question detail page and it will show up right here.</p>

				<?php include_partial('userTabs', array(
                                        'user' => $user,
                                        'currentPage' => $currentPage,
                                        'maxResultsPerPage' => $maxResultsPerPage
                                     )) ?>

				
                <?php echo include_component('question', 'questionList', array(
                                                                            'questions' => $favoriteQuestions,
                                                                            'ownerId' => $user->getId(),
                                                                            'base_route' => '@profile_favorite?display_name=' . myUtil::slugify($user->getDisplayName()) . '&userId=' . $user->getId()
                                            )) ?>

			</div><!-- / #main -->

			<div id="sidebar">

				<?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

                <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

			</div><!-- / #sidebar -->

		</div><!-- / #content -->