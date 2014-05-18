<div class="greenSidebar">

    <h3>Gear Companies</h3>

    <ul>

        <?php foreach($recent_companies as $company): ?>
        <li>
            
            <?php echo link_to(ucwords($company['GearCompany.FullName']), "@gear_company?company_name=" . myUtil::slugify($company['GearCompany.FullName'])) ?>
            <span class="score">
                <span title="We currently have <?php echo $company['count'] ?> pieces of gear for <?php echo $company['GearCompany.FullName'] ?>">
                    (<?php echo $company['count'] ?>)
                </span>
            </span>

        </li>
        <?php endforeach ?>
        
    </ul>

    <p class="right">
        <?php echo link_to('View More Companies &raquo', '@gear_companies') ?>
    </p>

</div><!-- #recentUsers -->