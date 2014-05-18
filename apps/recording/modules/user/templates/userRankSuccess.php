
<div id="content">

    <div id="main">

        <h1 class="title">Search For Users</h1>

        <p class="p2">Here some basic info about theis page, lorem ipsum dolor sit amet, ac semper lacus nulla vel. Justo integer erat eget wisi massa platea, vitae venenatis lacus enim rutrum libero, in blandit, occaecat pede pellentesque tortor, ante tempor platea lacinia justo.</p>

        <form class="searchUsers" method="post" action="">

            <p class="fields">

                Search users:
                <input type="text" class="text" />
                <input type="submit" class="submit" value="Search" />

            </p>

        </form>

        <div class="head-tabs">

            <ul class="nav">

                <li><?php echo link_to("Top Ranked", '@user', array('class' => 'active')) ?></li>
                <li><?php echo link_to("Oldest Users", '@user_newest') ?></li>
                <li><?php echo link_to("Newest Users", '@user_oldest') ?></li>
                <li><?php echo link_to("Most Active", '@user_most_active') ?></li>

            </ul>

        </div><!-- .head-tabs -->

        <ul class="list-users clearfix">

        <?php foreach($pager->getResults() as $user): ?>

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_04.jpg" alt="" /></p>

                <p class="user-stats-1">

                    <span class="user-name">
                    
                        <a href="#"><?php echo $user->getDisplayName() ?></a>

                    </span>
                    
                    - Experience Score: <span class="score"><?php echo $user->getExperienceScore() ?></span>
                    <!--
                    - Awards: <span class="user-win">(<a href="#">25</a>)</span>
                    -->
                    -

                </p>

                <p class="user-stats-2">

                    Questions: <span class="ask">Asked:</span> <strong>38</strong> |
                    
                    Questions: <span class="answer2">Answered:</span> <strong>15</strong> |

                    Votes Given: <span class="votes-given">582</span> |
                    
                    Votes Received: <span class="votes-received">321</span>

                </p>

            </li>

         <?php endforeach ?>

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

        <div class="wrap-box">

            <div class="box first">

                <h3>What is This?</h3>

                <p class="p3"><strong>RecordingQuestions</strong> Lorem ipsum dolor sit amet, sit morbi pede lacus, imperdiet fermentum purus ultricies venenatis, blandit id vel volutpat, risus pellentesque aliquam pellentesque maecenas. Nunc ligula donec dolor sed, at dolor imperdiet pede molestie, nibh turpis amet a id, tempus scelerisque ipsum in. Ut donec fringilla pellentesque magnis, diam ultricies viverra convallis justo. Integer sem sodales libero, eget egestas hendrerit venenatis tellus, lorem placerat ipsum suspendisse. Mollis nec amet velit morbi, consectetuer consectetuer morbi magna nulla.</p>

            </div><!-- .box -->

        </div><!-- .wrap-box -->

    </div><!-- / #sidebar -->

</div><!-- / #content -->