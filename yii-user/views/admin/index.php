<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);


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
        "url" => array("create"),
        "visible" => Yii::app()->user->checkAccess("UserAdmin")
    ));
    ?>
</div>
    <div class="btn-group">
        <h1>
            <i class="icon-user"></i>            
            <?= UserModule::t("User List"); ?>
        </h1>
    </div>
</div>        
</div>    
<div class="row">
<div class="span10">

<?php $defaultGridView = Yii::app()->getModule('user')->defaultGridView; ?>
<?php $this->widget($defaultGridView['path'], $defaultGridView['options'] + array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(

		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
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
                'update' => array('visible' => 'Yii::app()->user->checkAccess("UserAdmin")'),
                'delete' => array('visible' => 'FALSE'),
            ),
		),
	),
)); ?>
</div>