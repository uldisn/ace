<ul class="inbox-tabs nav nav-tabs padding-16 tab-size-bigger tab-space-1" id="inbox-tabs">
    <?php
    if ($write_mail) {
        ?>            
        <li class="li-new-mail pull-right">
            <a class="btn-new-mail" data-target="write" data-toggle="tab">
                <span class="btn bt1n-small btn-purple no-border">
                    <i class=" icon-envelope bigger-130"></i>
                    <span class="bigger-110">
                        <?php
                        echo $write_mail['label'];
                        ?>
                    </span>
                </span>
            </a>
        </li>
        <?php
    }
    foreach ($left_tabs as $tab) {
        ?>
        <li<?php echo $tab['active'] ? ' class="active"' : ''; ?>>
            <a data-target="<?php echo $tab['tab_code'] ?>" href="#inbox" data-toggle="tab">

                <i class="<?php echo isset($tab['color']) ? $tab['color'] : '';
    echo ' ' . isset($tab['icon']) ? $tab['icon'] : '';
        ?> bigger-130"></i>
                <span class="bigger-110"><?php echo $tab['label'] ?></span>
            </a>
        </li>
        <?php
    }
    ?>            
</ul>