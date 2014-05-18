<?php $categories = $sf_data->getRaw('categories'); ?>
<?php $studio_array = $sf_data->getRaw('studio_array'); ?>

<div class="blueSidebar">

    <h3>Browse By Category</h3>

    <ul>

        <?php foreach($categories as $category): ?>

            <?php if($category->getSection() != ""): ?>

            <li>

                    <?php echo link_to(ucwords($category->getSection()), "@gear_category?category_name=" . ucwords($category->getSection())) ?>
                    <span class="score">
                        <span title="">(<?php echo $category->getColumn('Count') ?>)</span>
                    </span>

            </li>

            <?php endif ?>
        
        <?php endforeach ?>

    </ul>

</div><!-- #recentUsers -->