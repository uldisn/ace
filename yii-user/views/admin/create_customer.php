<?php
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/customerAdmin"),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>UserModule::t("Customer List"),
                )
 ),true);

?>            
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-user"></i>
                <?php echo UserModule::t('Create Customer User');?>
            </h1>
        </div>
    </div>
</div>

<?php
    $view = '_form_customer';       
     if(Yii::app()->getModule('user')->view){
         $alt_view = Yii::app()->getModule('user')->view . '.admin.'.$view;
         if (is_readable(Yii::getPathOfAlias($alt_view) . '.php')) {
             $view = $alt_view;
             $this->layout=Yii::app()->getModule('user')->layout;
         }
     }         
	echo $this->renderPartial($view, array('model'=>$model,'profile'=>$profile));
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>UserModule::t("Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('#user-form').submit();",
                       ),
                    )); 
                    ?>
                  
        </div>
    </div>
</div>