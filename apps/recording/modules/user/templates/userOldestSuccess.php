
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

                <li><a href="#">Newest Users</a></li>
                <li><a href="#" class="active">Oldest Users</a></li>
                <li><a href="#">Awards Earned</a></li>
                <li><a href="#">Most Active</a></li>

            </ul>

        </div><!-- .head-tabs -->

        <ul class="list-users clearfix">

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_11.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">Konrad Rudolph</a></span> - Member Since: 10-25-2007 - Experience Score: <span class="score">2252</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">24</a>)</span> | <span class="ranked">Ranked <a href="#">#3</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>582</strong> - Questions: <span class="answer2">Answered:</span> <strong>321</strong></p>

            </li>

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_09.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">S.Lott</a></span> - Member Since: 11-15-2007 - Experience Score: <span class="score">958</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">24</a>)</span> | <span class="ranked">Ranked <a href="#">#3</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>582</strong> - Questions: <span class="answer2">Answered:</span> <strong>321</strong></p>

            </li>

            <li>

                <p class="user-avatar"><img src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/user_10.jpg" alt="" /></p>

                <p class="user-stats-1"><span class="user-name"><a href="#">James Curran</a></span> - Member Since: 11-20-2007 - Experience Score: <span class="score">1556</span></p>

                <p class="user-stats-2">Awards Earned: <span class="user-win">(<a href="#">24</a>)</span> | <span class="ranked">Ranked <a href="#">#3</a> (<a href="#">?</a>)</span> | Questions: <span class="ask">Asked:</span> <strong>582</strong> - Questions: <span class="answer2">Answered:</span> <strong>321</strong></p>

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