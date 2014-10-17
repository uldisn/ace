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
