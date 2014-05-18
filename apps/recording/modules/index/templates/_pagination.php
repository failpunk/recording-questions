<div id="pages">

<?php // navigation for each page ?>

<ul class="clearfix">

<?php if ($pager->haveToPaginate()): ?>

    <!-- Previous Button -->
    <?php if($pager->getPage() != $pager->getFirstPage()): ?>
        <li>
             <?php echo link_to(
                            'Prev',
                            myUtil::constructPaginationRoute($route, array('page' => $pager->getPreviousPage(), 'results' => $results_per_page))) ?>
        </li>
    <?php endif ?>
     
    <?php if($pager->getPage() == $pager->getFirstPage()): ?>
        <li>
            <?php echo link_to(
                            $pager->getFirstPage(),
                            myUtil::constructPaginationRoute($route, array('page' => $pager->getFirstPage(), 'results' => $results_per_page)),
                            array('class' => 'active')) ?>
        </li>
    <?php else: ?>
        <li>
            <?php echo link_to(
                        $pager->getFirstPage(),
                        myUtil::constructPaginationRoute($route, array('page' => $pager->getFirstPage(), 'results' => $results_per_page))) ?>
        </li>
    <?php endif ?>

    <?php if($pager->getPage() > 4): ?>
        <li>...</li>
    <?php endif ?>

    <?php $links = $pager->getLinks() ?>

    <?php foreach($links as $page): ?>

        <?php if($page != $pager->getFirstPage() && $page != $pager->getLastPage()): ?>

            <?php if($page == $pager->getPage()): ?>
                <li>
                    <?php echo link_to(
                                $page,
                                myUtil::constructPaginationRoute($route, array('page' => $page, 'results' => $results_per_page)),
                                array('class' => 'active')) ?>
                </li>
            <?php else: ?>
                <li>
                    <?php echo link_to(
                                $page,
                                myUtil::constructPaginationRoute($route, array('page' => $page, 'results' => $results_per_page))) ?>
                </li>
            <?php endif ?>

        <?php endif ?>

    <?php endforeach ?>

    <?php if($pager->getPage() < $pager->getLastPage() - 3): ?>
        <li>...</li>
    <?php endif ?>

    <?php if($pager->getPage() == $pager->getLastPage()): ?>
        <li>
            <?php echo link_to(
                        $pager->getLastPage(),
                        myUtil::constructPaginationRoute($route, array('page' => $pager->getLastPage(), 'results' => $results_per_page)),
                        array('class' => 'active')) ?>
        </li>
    <?php else: ?>
        <li>
            <?php echo link_to(
                        $pager->getLastPage(),
                        myUtil::constructPaginationRoute($route, array('page' => $pager->getLastPage(), 'results' => $results_per_page))) ?>
        </li>
    <?php endif ?>

    <li>
        <?php echo link_to(
                    'Next',
                    myUtil::constructPaginationRoute($route, array('page' => $pager->getNextPage(), 'results' => $results_per_page))) ?>
    </li>

    <?php else: ?>

        <li>
            <?php echo link_to(
                        $pager->getFirstPage(),
                        myUtil::constructPaginationRoute($route, array('page' => $pager->getFirstPage(), 'results' => $results_per_page)),
                        array('class' => 'active')) ?>
        </li>

    <?php endif ?>

</ul>


<?php // number of results to display per page ?>
<ul id="questionPage" class="clearfix">

    <li>Results Per Page:</li>

    <?php if($pager->getMaxPerPage() == 15): ?>
        <li>
            <a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 15))) ?>" class="active">15</a>
        </li>
    <?php else: ?>
        <li><a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 15))) ?>">15</a></li>
    <?php endif ?>


    <?php if($pager->getMaxPerPage() == 30): ?>
        <li><a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 30))) ?>" class="active">30</a></li>
    <?php else: ?>
        <li><a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 30))) ?>">30</a></li>
    <?php endif ?>


    <?php if($pager->getMaxPerPage() == 50): ?>
        <li><a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 50))) ?>" class="active">50</a></li>
    <?php else: ?>
        <li><a href="<?php echo url_for(myUtil::constructPaginationRoute($route, array('page' => $pager->getPage(), 'results' => 50))) ?>">50</a></li>
    <?php endif ?>

</ul>

</div><!-- #pages -->