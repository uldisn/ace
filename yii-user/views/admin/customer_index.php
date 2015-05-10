<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">  
<?php 
    $this->widget("bootstrap.widgets.TbButton", array(
        "label" => UserModule::t('Create'),
        "icon" => "icon-plus",
        "size"=>"large",
        'type'=>'success',
        "url" => array('Create','type'=>'customer'),
        "visible" => Yii::app()->user->checkAccess("UserAdmin")
    ));
    ?>
</div>
    <div class="btn-group">
        <h1>
            <i class="icon-user"></i>            
            <?= UserModule::t("Customer User List"); ?>
        </h1>
    </div>
</div>        
</div>    
<div class="row">
<div class="span10">

<?php $defaultGridView = Yii::app()->getModule('user')->defaultGridView; ?>
<?php $this->widget($defaultGridView['path'], $defaultGridView['options'] + array(
	'id'=>'user-grid',
	'dataProvider'=>$model->searchCustomers(),
	//'filter'=>$model,
	'columns'=>array(

		array(
			'name' => 'ccmp_name',
            'type' => 'raw',
            'header' => UserModule::t("Customer Company"),
		),
        array(
			'name' => 'first_name',
            'value' => '$data->profile->first_name',
        ),    
        array(
			'name' => 'last_name',
            'value' => '$data->profile->last_name',
        ),    
//        array(
//			'name' => 'last_name',
//        ),    
//		array(
//			'name' => 'username',
//		),
		array(
			'name'=>'email',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			//'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewCustomer", array("id" => $data->id))',
		),
	),
)); ?>
</div>