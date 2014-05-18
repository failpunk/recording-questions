
<div id="content">
		
    <div id="main">

        <h1 class="title">Awards</h1>

        <p class="p2">Since a good community is all about contributions, we figure it's only right to give out awards to those who provide their help.  Here you will find a list of awards and the requirements needed in order get them. (We've highlighted the awards you have already received.)</p>

        <ul class="list-awards">
        <?php $first = true ?>
        <?php foreach($awards as $award): ?>
            <?php $class_first = ($first) ? 'first' : '' ?>
            <?php foreach($awarded as $item): ?>
                <?php $class_awarded = '' ?>
                <?php if($item->getAwardId() == $award->getId()): ?>
                    <?php $class_awarded = ' awarded' ?>
                    <?php break; ?>
                <?php endif ?>
            <?php endforeach ?>
        <li class="<?php echo $class_first.$class_awarded ?>"><span class="<?php echo $award->getType() ?>"><a href="#"><?php echo $award->getName() ?></a> (<?php echo awardActions::getAwardCount($award->getId()) ?>)</span> <span class="txt"><?php echo $award->getDescription() ?></span></li>
            <?php $first = false ?>
        <?php endforeach ?>
        
        </ul>

    </div><!-- / #main -->

    <div id="sidebar">

        <div class="wrap-box">

            <div class="box first">
                <!--
                <h3>My Awards</h3>

                <ul class="my-awards">

                    <li class="first"><span class="mastering"><a href="#">Great Answer</a></span> 10-25-2008</li>
                    <li><span class="engineer"><a href="#">Good Question</a></span> 10-05-2008</li>
                    <li><span class="engineer"><a href="#">Citizen Patrol</a></span> 10-25-2008</li>
                    <li><span class="assistant"><a href="#">Commentator</a></span> 01-15-2009</li>

                </ul>
                -->
                <div class="about-awards">

                    <h4>About the Awards</h4>

                    <h5><span class="assistant">Assistant Awards</span></h5>

                    <p>These awards are the easiest to obtain as most are given for simple actions throughout the site.  You should have a good grasp for the site after obtaining most of these.</p>

                    <h5><span class="engineer">Engineer Awards</span></h5>

                    <p>These awards will be given to the more interactive members of the community.  These will take a bit of work and patience to obtain.</p>

                    <h5><span class="mastering">Mastering Awards</span></h5>

                    <p>These are the hardest awards to obtain and will take a great deal of work to get your hands on.  Only a select group will be able to showcase these awards.</p>

                </div>

            </div><!-- .box -->

        </div><!-- .wrap-box -->

    </div><!-- / #sidebar -->

</div><!-- / #content -->