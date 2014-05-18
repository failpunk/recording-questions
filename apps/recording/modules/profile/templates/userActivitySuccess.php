<?php use_helper('Form', 'jQuery', 'custom'); ?>

		<div id="content">

			<div id="main">

				<h1 class="title"><strong>Recent Activity for <?php echo ucfirst($user->getDisplayName()) ?></strong></h1>

				<!--<p class="experience">Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span> - Ranked <a href="#">#<?php echo $userRank ?></a> (<a href="#">?</a>)</p>-->

				<p class="p2">This is a listing of all your recent activity on the site.  Come here if you can't remember that great question you may have answered the other day or to see how many comments you have left in the last week.</p>

				<?php include_partial('userTabs', array(
                                        'user' => $user,
                                        'currentPage' => $currentPage,
                                        'maxResultsPerPage' => $maxResultsPerPage
                                     )) ?>

				<p class="p1"><strong>Displaying activity of the last 3 months</strong> - <a href="#">Display all time activity</a></p>

				<ul class="list-profile">

					<li class="first">

						<p class="date1">04.15.2009</p>

						<p><span class="ask">Asked:</span> <a href="#">Lorem ipsum dolor sit amet, ac semper enim rutrum lacus nulla vel. Justo integer erat eget wisi massa platea, vitae venenatis lacus enim rutrum libero, in blandit?</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="answer2">Answered:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="flag">Atention:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p class="user-win">You have earned <a href="#">"exemplum"</a> award.</p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="answer2">Answered:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="ask">Asked:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="ask">Asked:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="answer2">Answered:</span><a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="ask">Asked:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

					<li>

						<p class="date1">04.10.2009</p>

						<p><span class="ask">Asked:</span> <a href="#">Eleifend sapien, donec dapibus eros blandit, sapien lectus laoreet est torquent erat, amet ullamcorper erat.</a></p>

					</li>

				</ul>

				<div id="pages">

						<ul class="clearfix">

							<li><a class="active" href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>

						</ul>

						<ul class="clearfix" id="questionPage">

							<li class="first">Activities Per Page:</li>
							<li><a class="active" href="#">10</a></li>
							<li><a href="#">30</a></li>
							<li><a href="#">50</a></li>

						</ul>

					</div><!-- #pages -->

			</div><!-- / #main -->

			<div id="sidebar">

				<?php include_component('profile', 'userProfile', array('currentUser' => $user)) ?>

                <?php include_partial('index/googleAds', array('unit' => 'studio')) ?>

			</div><!-- / #sidebar -->

		</div><!-- / #content -->