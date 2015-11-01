<div class="widget-container-span ui-sortable no-margin">
    <div class="widget-box">
        <div class="widget-header <?=$header_color?>">
            <h5>
                <i class="<?php echo $header_icon_class; ?>"></i>
                <?php echo $header_text; ?>
            </h5>
            <div class="widget-toolbar">
                <?=$toolbar?>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <?php
                            foreach ($tableHead as $head) {
                                ?>
                                <th><?= $head ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $body ?>
                    </tbody>
                </table>
            </div>            
        </div>
    </div>
</div>
