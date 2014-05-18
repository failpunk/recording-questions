<?php use_helper('Form', 'Gravatar', 'custom') ?>

<div id="content">

<div id="top">

<h2>Got recording questions?</h2>

<p id="subTitle">Get the best answers from audio engineers online!</p>
<?php if(!isset($nav)): ?>
    <?php $nav = "relevance" ?>
<?php endif; ?>
<?php echo form_tag("index/search", array('method' => 'get', 'class' => 'search', 'id' => 'search')) ?>
<p class="fields"><input name="search" id="searchField" type="text"
	class="text" value="Search for questions right here..."
	onfocus="this.value='';"
	onblur="if(!this.value)this.value='Search for questions right here...';" />

<input type="image"
	src="<?php echo sfContext::getInstance()->getRequest()->getRelativeUrlRoot() ?>/images/bt_searchHome.gif"
	value="Search"></input></p>

</form>

<p>or <a href="<?php echo url_for('@ask_question') ?>">Submit your own
question</a></p>

</div>
<!-- #top -->
<!--
<div id="alertTop" class="popup one">

<h4>Congratulations! You have earned <strong>1</strong> experience
point.</h4>

<p>You have earned <strong>1</strong> additional experience point. Amet
auctor, ligula porta ultrices nunc. Sem eu vestibuahsq <a href="#">honcus
curab</a> itur temporlur temp.</p>

<p class="close"><a href="#">X</a></p>

</div>
 -->
<!-- .popup -->

<div id="main">

<?php if(isset($pager)): ?>
    <?php if($nav == 'relevance' || $nav == null): ?>
        <?php $res = $sf_data->getRaw('pager')->getResults() ?>
    <?php else: ?>
        <?php $res = $sf_data->getRaw('pager')->getResults(false) ?>
    <?php endif; ?>

	<?php if (!empty($res)): ?>

<div class="head-tabs">

<h3 class="feed"><?php echo getLableNavigation($nav) ?></h3>

<p class="rss-title"><?php echo link_to("Rss", 'index/search?nav='.$nav.'&search='.$search.'&rss=true', array('class' => 'rss')) ?></p>
<ul class="nav">
<?php if($nav == null || $nav == "relevance"): ?>
	<li><?php echo link_to_active('Relevance' ,'index/search?nav=relevance&search='.$search, 'active', true) ?></li>
	<?php else: ?>
	<li><?php echo link_to_active('Relevance' ,'index/search?nav=relevance&search='.$search, 'active') ?></li>
	<?php endif; ?>
	<li><?php echo link_to_active('Newest' ,'index/search?nav=newest&search='.$search,'active') ?></li>
	<li><?php echo link_to_active('Most Votes' ,'index/search?nav=most_votes&search='.$search,'active') ?></li>
	<li><?php echo link_to_active('Most Active' ,'index/search?nav=most_active&search='.$search, 'active') ?></li>
</ul>
</div>
<!-- .head-tabs -->

 
<ol id="searchResults">
<?php foreach ($res as $item): ?>


	<li>
	<h4><?php echo link_to($item->getTitle(), "@question_detail?question_title=".myUtil::createSlug($item->getTitle())."&question_id=".$item->getId()) ?></h4>

	<p class="avatar"><?php echo gravatar_image_tag($item->getUser()->getEmail())?></p>
    
	<p><?php echo substr(strip_tags($item->getDescription()), 0, sfConfig::get('app_question_description_length')) ?></p>

	<?php echo link_to("Rss", "@rss_for_question_detail?questionId=".$item->getId(), array("class" => 'rss')) ?>
	 viewed <a class="times"
		href="#"><strong><?php echo $item->getVisited() ?></strong> times</a>
	| asked by <?php echo $item->getUser()->getDisplayName() //echo link_to($question->getUser()->getDisplayName(), ) ?>
	<?php echo date_age_tag($item->getCreatedAt()) ?></p>

	<?php echo include_component('question', 'tags', array('question' => $item)) ?>

	<div class="answvot-normal">

	<p class="answer"><?php echo link_to('<span class="num">'.$item->getColumn('total_answer').'</span>Answers', "@question_detail?question_title=".myUtil::createSlug($item->getTitle())."&question_id=".$item->getId()) ?></a></p>

	<p class="vot"><?php echo link_to('<span class="num">'.$item->getTotalVotes().'</span>Votes', "@question_detail?question_title=".myUtil::createSlug($item->getTitle())."&question_id=".$item->getId()) ?></p>

	</div>
	</li>

	<?php endforeach ?>

</ol>

<?php if($nav == null): ?> 
    <?php $nav = "relevance" ?>
<?php endif; ?>

<div id="pages"><?php if ($pager->haveToPaginate()): ?>
<ul class="clearfix">


<?php $links = $pager->getLinks();?>
                    <?php if($numbIndice > 1): ?>
                    <ul class="clearfix">
                        <?php $numberIndice = 1 ?>

                            <?php if($currentPage-1 != 0): ?>
                                <?php $prev = $currentPage-1 ?>
                                <li><?php echo link_to("Prev", 'index/search?nav='.$nav.'&search='.$search.'&page='.$prev.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$prev)  ?></a></li>
                            <?php endif; ?>
                            <?php $flag = false; ?>
                            <?php while ($numberIndice <= $numbIndice): ?>

                                <?php // @TODO HARD CODE ?>


                                <!--  1 2 3 4 5 ... 100  -->
                                <?php if($numbIndice > 5 && $currentPage < 5): ?>
                                    <?php $flag = true; ?>
                                    <?php if($numberIndice <= 5 || $numberIndice == $numbIndice): ?>

                                       <?php if($numberIndice == $currentPage): ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&currentPage='.$numberIndice, array('class' => 'active')) ?></a></li>
                                       <?php else: ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                       <?php endif; ?>


                                     <?php endif; ?>

                                     <?php if($numberIndice == 5): ?>
                                       <li>...</li>
                                     <?php endif; ?>

                                <?php endif; ?>



                                <!--  1 ... 3 4 5 6 7 ... 100  -->
                                <?php if($numbIndice > 5 && $currentPage >= 5 && $currentPage <= $numbIndice - 4 && $currentPage < $numbIndice): ?>

                                    <?php if($numberIndice == 1 ): ?>
                                        <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                        <li>...</li>
                                    <?php endif; ?>

                                    <?php if( ($numberIndice >= $currentPage - 2) && ($numberIndice <= $currentPage + 2) ): ?>
                                        <?php if($numberIndice == $currentPage): ?>
                                            <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice, array('class' => 'active')) ?></a></li>
                                        <?php else: ?>
                                            <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                    <?php if($numberIndice == $numbIndice): ?>
                                        <li>...</li>
                                        <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                    <?php endif; ?>

                                <?php endif; ?>




                                <!-- 1 2 3 4 5 -->
                                <?php if($numbIndice <= 5): ?>
                                       <?php if($numberIndice == $currentPage): ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&currentPage='.$numberIndice, array('class' => 'active')) ?></a></li>
                                       <?php else: ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                       <?php endif; ?>
                                <?php endif; ?>



                                <!--  1 ... 96 97 98 99 100  -->
                                <?php if($numbIndice > 5 && $currentPage > $numbIndice - 4 && !$flag): ?>

                                    <?php if($numberIndice == 1): ?>
                                        <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                        <li>...</li>
                                    <?php endif; ?>

                                    <?php if($numberIndice > $numbIndice - 5): ?>
                                       <?php if($numberIndice == $currentPage): ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&currentPage='.$numberIndice, array('class' => 'active')) ?></a></li>
                                       <?php else: ?>
                                         <li><?php echo link_to($numberIndice, 'index/search?nav='.$nav.'&search='.$search.'&page='.$numberIndice.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$numberIndice) ?></a></li>
                                       <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>



                                <?php $numberIndice++; ?>

                            <?php endwhile; ?>

                            <?php if($currentPage != $numbIndice): ?>
                                <?php $next = $currentPage+1 ?>
                                <li><?php echo link_to("Next", 'index/search?nav='.$nav.'&search='.$search.'&page='.$next.'&maxResultsPerPage='.$maxResultsPerPage.'&currentPage='.$next)  ?></a></li>
                            <?php endif; ?>

                        </ul>
                        <?php endif; ?>
<?php endif; ?>

<ul class="clearfix" id="questionPage">

	<li>Questions Per Page:</li>
	<?php if($maxResultsPerPage == '15'): ?>
	<li><?php echo link_to('15', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=15', array('class' => 'active')) ?></li>
	<?php else: ?>
	<li><?php echo link_to('15', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=15') ?></li>
	<?php endif; ?>
	<?php if($maxResultsPerPage == '30'): ?>
	<li><?php echo link_to('30', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=30', array('class' => 'active')) ?></li>
	<?php else: ?>
	<li><?php echo link_to('30', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=30') ?></li>
	<?php endif; ?>
	<?php if($maxResultsPerPage == '50'): ?>
	<li><?php echo link_to('50', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=50', array('class' => 'active')) ?></li>
	<?php else: ?>
	<li><?php echo link_to('50', 'index/search?nav='.$nav.'&search='.$search.'&currentPage='.$pager->getPage().'&maxResultsPerPage=50') ?></li>
	<?php endif; ?>

</ul>

	</div>

    <?php else: ?>
        <h3>We were unable to find any questions for you...</h3>

        <h4>We suggest you try the following:</h4><br/><br/>

        <h3 class="subtitle">Double check your spelling</h3>
        <p class="p4">We all make spelling mistakes, unfortuantly computers don't like to spell either.</p>

        <h3 class="subtitle">Try your search using different words or phrases</h3>
        <p class="p4">Sometimes questions can be asked using other similar words and phrases.  Try a slightly different combination with your next search. </p>

        <h3 class="subtitle">Ask your own question</h3>
        <p class="p4">Hey, maybe no one has asked your question yet.  <?php echo link_to('Ask a new question', '@ask_question') ?>.</p>

    <?php endif ?>

<!-- #pages --></div>
<!-- / #main -->

<div id="sidebar">

    <?php include_component('index', 'recentAnswers') ?>

    <?php include_component('gear', 'recentActivity') ?>

    <?php include_partial('index/googleAds') ?>

    <?php include_component('user', 'recentUsers') ?>

    <?php include_component('index', 'tagCloud') ?>
    
</div><!-- / #sidebar -->

</div><!-- / #content -->


	<?php endif; ?>