<?php
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("RasModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>array(
        "view",
        'id' => $model->id
    ),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>UserModule::t("User List"),
                )
 ),true);
?>    
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-lock"></i>
                <?php echo UserModule::t('Code Card');?>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            
            ?>
        </div>
    </div>
</div>

<?php

if ($error) {
    ?>
    <div class="alert alert-danger"><i class="ace-icon fa fa-times"></i> <?php echo $error; ?></div>
    <?php
}

if (isset($reply['reply_type'])) {
    
    switch ($reply['reply_type']) {
        case 'code_card':
            // Print codes
            ?>
            
            <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" style="width: 320px;">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title"><?php echo UserModule::t("Expire date"); ?> <?php echo $reply['add_data']['expire_date']; ?></h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <?php
                            $length = strlen(count($reply['add_data']['codes']));
                            
                            foreach ($reply['add_data']['codes'] as $nr => $code) {
                                $nr = str_pad($nr, $length, '0', STR_PAD_LEFT);
                                ?>
                                <div style="float: left; margin: 5px;"><span style="font-weight: bold;"><?php echo $nr; ?></span> <?php echo $code; ?></div>
                                <?php
                            }
                            ?>
                            <div style='clear:both'></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            break;
        
        case 'validate_code':
            // Show code input form
            $this->beginWidget(
                'CActiveForm',
                array(
                    'id'=>'code-card-form',
                    'action'=>array(
                        "genCodeCard",
                        'id' => $model->id,
                        'request_type' => 'validate_code'
                    ),
                )
            );
            ?>
            <div class="alert alert-warning"><i class="ace-icon fa fa-key"></i> <?php echo UserModule::t("Enter the code from the code card"); ?></div>
            <div class="form-group">
                <label for="code" style="width: 85px; margin-top:5px; margin-bottom: 15px; float: left;" class="col-sm-3 control-label no-padding-right"><?php echo UserModule::t("Code Nr.") . ' ' . $reply['add_data']; ?></label>
                
                <div class="col-sm-9" style="float:left; margin-right: 5px;">
					<input type="text" class="col-xs-10 col-sm-5 input-mini" placeholder="<?php echo UserModule::t("Code"); ?>" id="code" name="code"/>
				</div>
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>UserModule::t("OK"),
                        "icon"=>"fa-check icon-white",
                        "size"=>"small",
                        "type"=>"primary",
                        "htmlOptions"=> array(
                            "onclick"=>"$('#code-card-form').submit();",
                            "style" => "line-height:22px;",
                        ),
                    )); 
                ?>
			</div>
            <input type="hidden" name="session_id" value="<?php echo $reply['session_id']; ?>" />
            <?php $this->endWidget(); ?>
            <?php
            break;
        
    }
    
}
