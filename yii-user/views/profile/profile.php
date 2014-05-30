<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

?>
<h1><?php echo UserModule::t('Your profile'); ?></h1>
<div class="span7">
        
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
        
<?php 
        $this->widget(
            'TbDetailView', 
            array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'name' => 'username',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'create_at',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'lastvisit_at',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'status',
                        'value' => CHtml::encode(User::itemAlias("UserStatus",$model->status)),
                        
                    ),
                    

                )
            )
        );
?>
      
        

</div>