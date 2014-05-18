<div class="head-tabs">

    <h3><?php echo $title ?></h3>

</div><!-- .head-tabs -->

<div class="ebay">

    <ol class="activity-list" id="searchResults">

        <?php foreach($results as $result): ?>
        <li>

            <span class="price">
                $<?php echo Ebay::getPrice($result) ?>
            </span>

            <h4><a href="<?php echo Ebay::getLink($result) ?>"><?php echo Ebay::getTitle($result) ?></a></h4>

            <p class="avatar">
                <a href="<?php echo Ebay::getLink($result) ?>">
                    <img width="90" height="90" src="<?php echo Ebay::getPic($result) ?>" class="gravatar_photo" alt="Gravatar photo"/>
                </a>
            </p>

            <p>
                <?php echo Ebay::getTimeLeft($result) ?>
                <span>remaining in auction</span>
            </p>

        </li>
        <?php endforeach ?>

        <li>

            <p class="link">
                <a target="_self" href="http://rover.ebay.com/rover/1/711-53200-19255-0/1?icep_ff3=1&pub=5574868678&toolid=10001&campid=5336448967&customid=&ipn=psmain&icep_vectorid=229466&kwid=902099&mtid=824&kw=lg">Looking for gear? Search Ebay for yourself!</a><img style="text-decoration:none;border:0;padding:0;margin:0;" src="http://rover.ebay.com/roverimp/1/711-53200-19255-0/1?ff3=1&pub=5574868678&toolid=10001&campid=5336448967&customid=&mpt=[CACHEBUSTER]">
            </p>

        </li>

    </ol>

    <div style="clear:both;"></div>

</div>