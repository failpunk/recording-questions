<?php use_helper('Form', 'jQuery', 'custom'); ?>

<script type="text/javascript">

    $().ready(function()
    {
        var answerUrl = '<?php echo url_for('@profile_show_question?questionPage=1&userId='.$user->getId()) ?>';

        // Bind click for question button
        $('p.show-comments').click(function() {
            togglePosts(this);
        });

    });

</script>

		<div id="content">

			<div id="main">

                <h1 class="title"><strong>Statistics for <?php echo ucfirst($user->getDisplayName()) ?></strong></h1>

				<!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

				<p class="p2">You can come here to view all your different achievements.  We'll do our best to keep track of all the important information you might want to know about your activity.</p>

                <?php include_partial('userTabs', array(
                                        'user' => $user,
                                        'currentPage' => $currentPage,
                                        'maxResultsPerPage' => $maxResultsPerPage
                                     )) ?>

				<ul class="list-stats">
					<li>

						<p class="date1">Awards Earned:</p>

						<p>
                            <span title="Assistant Awards" class="assistant award">(<?php echo $award_count['assistant'] ?>)</span>
                            <span title="Engineer Awards" class="engineer award">(<?php echo $award_count['engineer'] ?>)</span>
                            <span title="Mastering Awards" class="mastering award">(<?php echo $award_count['mastering'] ?>)</span>
                        </p>

					</li>
                    
					<li>

						<p class="date1">Questions Asked:</p>

						<p><span class="ask">Asked:</span> <?php echo count($userQuestion) ?></p>

                        <?php echo include_component('profile',
                                                     'userPosts',
                                                     array(
                                                        'type' => 'question',
                                                        'userId' => $user->getId()
                                                     )) ?>

					</li>

					<li>

						<p class="date1">Questions Answered:</p>

						<p><span class="answer2">Answered:</span> <?php echo count($userAnswer) ?></p>

                        <?php echo include_component('profile',
                                                     'userPosts',
                                                     array(
                                                        'type' => 'answer',
                                                        'userId' => $user->getId()
                                                     )) ?>

					</li>

                    <li>

						<p class="date1">Comments Posted:</p>

                        <p><span class="comment-flag">Comments:</span> <?php echo $userCommentCount ?></p>

                        <?php echo include_component('profile',
                                                     'userComments',
                                                     array(
                                                        'userId' => $user->getId()
                                                     )) ?>

					</li>

					<li>

						<p class="date1">Votes Given:</p>

						<p class="point1"><?php echo $userGivenVote ?></p>

					</li>

					<li>

						<p class="date1">Votes Received:</p>

						<p class="point2"><?php echo $userReceivedVote ?></p>

					</li>

				</ul>

			</div><!-- / #main -->

			<div id="sidebar">
              
				<?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

                <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

			</div><!-- / #sidebar -->

		</div><!-- / #content -->