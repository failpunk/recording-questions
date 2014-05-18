<?php foreach ($results as $result): ?>
    <?php if($result['type'] == 'company'): ?>
        <a href="<?php echo url_for('@gear_company?company_name=' . myUtil::slugify($result['name'])) ?>"><span class="result-type company"><span>company</span></span><?php echo $result['name'] ?></a>
    <?php else: ?>
        <a href="<?php echo url_for('@gear_item?company_name=' . myUtil::slugify($result['company']) . '&gear_name=' . myUtil::slugify($result['name']) . '&gear_id=' . $result['id']) ?>"><span class="result-type gear"><span>gear</span></span><?php echo $result['company'] . ' ' . $result['name'] ?></a>
    <?php endif ?>
<?php endforeach; ?>