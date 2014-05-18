
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

                <li><a href="#" class="active">Newest Users</a></li>
                <li><a href="#">Oldest Users</a></li>
                <li><a href="#">Awards Earned</a></li>
                <li><a href="#">Most Active</a></li>

            </ul>

        </div><!-- .head-tabs -->

        <ul class="list-users clearfix">

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_12.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">Konrad Rudolph</a></span> - Member Since: 1 hour ago - Experience Score: <span class="score">1</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">0</a>)</span> | <span class="ranked">Ranked <a href="#">#13</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>5</strong> - Questions: <span class="answer2">Answered:</span> <strong>12</strong></p>

            </li>

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_07.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">Chris Jester-Young</a></span> - Member Since: 5 hour ago - Experience Score: <span class="score">5</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">0</a>)</span> | <span class="ranked">Ranked <a href="#">#13</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>5</strong> - Questions: <span class="answer2">Answered:</span> <strong>12</strong></p>

            </li>

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_08.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">Jonathan Leffler</a></span> - Member Since: 12 hour ago - Experience Score: <span class="score">10</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">0</a>)</span> | <span class="ranked">Ranked <a href="#">#13</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>5</strong> - Questions: <span class="answer2">Answered:</span> <strong>12</strong></p>

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

        <div class="wrap-box">

            <div class="box first">

                <h3>What is This?</h3>

                <p class="p3"><strong>RecordingQuestions</strong> Lorem ipsum dolor sit amet, sit morbi pede lacus, imperdiet fermentum purus ultricies venenatis, blandit id vel volutpat, risus pellentesque aliquam pellentesque maecenas. Nunc ligula donec dolor sed, at dolor imperdiet pede molestie, nibh turpis amet a id, tempus scelerisque ipsum in. Ut donec fringilla pellentesque magnis, diam ultricies viverra convallis justo. Integer sem sodales libero, eget egestas hendrerit venenatis tellus, lorem placerat ipsum suspendisse. Mollis nec amet velit morbi, consectetuer consectetuer morbi magna nulla.</p>

            </div><!-- .box -->

        </div><!-- .wrap-box -->

    </div><!-- / #sidebar -->

</div><!-- / #content -->