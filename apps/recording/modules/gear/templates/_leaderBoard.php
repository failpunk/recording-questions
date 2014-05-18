<div class="greenSidebar leaderboard">

    <h3>Leaderboard</h3>

    <ul>

        <li>

            <a class="section" href="/profile/justin-vencel/2">Added Most New Gear</a>

            <div>

                <?php foreach($most_gear as $leader): ?>

                <p>
                    <?php echo link_to($leader->getUser()->getDisplayName(), html_entity_decode($leader->getUser()->getRoute())) ?>
                    <span>
                        (<?php echo $leader->getColumn('total') ?>)
                    </span>
                </p>

                <?php endforeach ?>

            </div>

        </li>

        <li>

            <a class="section" href="/profile/justin-vencel/2">Submitted Most Site Reviews</a>

             <div>

                <?php foreach($site_review as $leader): ?>

                <p>
                    <?php echo link_to($leader->getUser()->getDisplayName(), html_entity_decode($leader->getUser()->getRoute())) ?>
                    <span>
                        (<?php echo $leader->getColumn('total') ?>)
                    </span>
                </p>

                <?php endforeach ?>

            </div>

        </li>


        <li>

            <a class="section" href="/profile/justin-vencel/2">Wrote Most User Reviews</a>

             <div>

                <?php foreach($user_review as $leader): ?>

                <p>
                    <?php echo link_to($leader->getUser()->getDisplayName(), html_entity_decode($leader->getUser()->getRoute())) ?>
                    <span>
                        (<?php echo $leader->getColumn('total') ?>)
                    </span>
                </p>

                <?php endforeach ?>

            </div>

        </li>

    </ul>

    <p class="right">
        <a href="/activity">View More Recent Activity »</a>
    </p>

</div><!-- #recentUsers -->