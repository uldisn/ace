<div class="message-content">
    <div class="message-header clearfix">
        <div class="pull-left">
            <span class="blue bigger-125"><?php echo Yii::t('models',$model_name);?></span>
            &nbsp;
            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
			</span>
            &nbsp;
            <span class="blue bigger-125">
                <?php echo $model_label;?>
                <?php 
                if($model_link){
                    ?>
                <a href="<?php echo $model_link;?>" target="_blank">
                    <i class="icon-external-link"></i>
                </a>    
                <?php                
                }
                ?>
                
            </span>
            &nbsp;
            <span class="divider">
				<i class="icon-angle-right arrow-icon"></i>
			</span>
            &nbsp;
            <span class="blue bigger-125"><?php echo $subject;?></span>

            <div class="space-4"></div>

            <a class="sender" href="<?php echo $sender_link;?>"><?php echo $sender;?></a>

            &nbsp;
            <i class="icon-time bigger-110 orange middle"></i>
            <span class="time"><?php echo $created;?></span>
        </div>
    </div>

    <div class="hr hr-double"></div>

    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100px;">
        <div class="message-body" style="overflow: hidden; width: auto; height: 100px;">
            <?php echo $message;?>
        </div>
        <div class="slimScrollBar ui-draggable" style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 200px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
        </div>
    </div>
</div>