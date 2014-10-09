<div class="widget-container-span ui-sortable no-margin">
    <div class="widget-box">
        <div class="widget-header header-color-blue">
            <h5><i class="<?php echo $header_icon_class; ?>"></i><?php echo $header_text; ?></h5>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-6">
                <?php 
                foreach($error_allert as $alert){
                ?>
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="icon-remove"></i>
						</button>                                     
                        <i class="icon-remove"></i>
                        <?php echo $alert; ?>
                    </div>                    
                <?php
                }
                foreach($warning_allert as $alert){
                ?>
                    <div class="alert alert-warning">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="icon-remove"></i>
						</button>                                     
                        <i class="icon-fire"></i>
                        <?php echo $alert; ?>
                    </div>                    
                <?php
                }
                foreach($info_allert as $alert){
                ?>
                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="icon-remove"></i>
						</button>                        
                        <i class="icon-info-sign"></i>
                        <?php echo $alert; ?>
                    </div>                    
                <?php
                }
                
                echo $body; 
                ?>
            </div>        
        </div>
    </div>
</div>
