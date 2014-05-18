<?php use_helper('Gravatar') ?>

<div id="gear-owners-own" style="display: <?php echo (isset ($display_has)) ? $display_has : 'none' ?>;">

    <div class="head-tabs">

        <a class="right-link members own" href="#">view members who want this (<?php echo count($wants) ?>)</a>

        <h3>Members Who Own This (<?php echo count($has) ?>)</h3>

    </div><!-- .head-tabs -->

    <div class="member-list">

        <ul>

            <?php foreach($has as $user): ?>
            <li>

                    <p class="avatar">
                        <a href="<?php echo url_for(html_entity_decode($user->getRoute())) ?>">
                            <?php echo gravatar_image_tag($user->getEmail())?>
                        </a>
                        <a href="<?php echo url_for(html_entity_decode($user->getRoute())) ?>"><?php echo $user->getDisplayName() ?></a>
                    </p>

            </li>

            <?php endforeach ?>

        </ul>

        <div style="clear:both;"></div>

    </div>

</div>

<div id="gear-owners-want" style="display: <?php echo (isset ($display_wants)) ? $display_wants : 'none' ?>;">

    <div class="head-tabs">

        <a class="right-link members want" href="#">view members who own this (<?php echo count($has) ?>)</a>

        <h3>Members Who Want This (<?php echo count($wants) ?>)</h3>

    </div><!-- .head-tabs -->

    <div class="member-list">

        <ul>

            <?php foreach($wants as $user): ?>
            <li>

                    <p class="avatar">
                        <a href="<?php echo url_for(html_entity_decode($user->getRoute())) ?>">
                            <?php echo gravatar_image_tag($user->getEmail())?>
                        </a>
                        <a href="<?php echo url_for(html_entity_decode($user->getRoute())) ?>"><?php echo $user->getDisplayName() ?></a>
                    </p>

            </li>

            <?php endforeach ?>

        </ul>

        <div style="clear:both;"></div>

    </div>

</div>