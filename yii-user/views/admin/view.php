<?php
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("RasModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
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
                <i class="icon-user"></i>
                <?php echo UserModule::t('View User');?>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            
            ?>
        </div>
    </div>
</div>
    
<div class="row">
	<div class="span3">


<?php
 
	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		'password',
		'email',
		'create_at',
		'lastvisit_at',
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
    $defaultDetailView = Yii::app()->getModule('user')->defaultDetailView;
    $this->widget($defaultDetailView['path'], $defaultDetailView['options'] + array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
?>
<div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
</div>        
    </div>
    <div class="span1"></div>
            <?php 
            /**
             * ROLES
             */
            ?>
            <div class="span3"> <!-- main inputs -->
                <h2><?php echo UserModule::t('Roles'); ?></h2>

            <?php 
            $form=$this->beginWidget('CActiveForm', array('id'=>'user-rolls'));
            $aChecked = Authassignment::model()->getUserRoles($model->id);
            if (count($aChecked) == 1){
                //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
                $aChecked = $aChecked[0];
            }
            $UserAdminRoles = Yii::app()->getModule('user')->UserAdminRoles;
            $list = array();
            foreach ($UserAdminRoles as $role_name){
                $list[$role_name] = $role_name;
            }
            echo CHtml::checkBoxList(
                    'user_role_name', 
                    $aChecked, 
                    $list,
                    array ( 'labelOptions'=>array('style'=>'display: inline'))
                    );
             
             
            /**
             * SYS companies
             */
            $companies_list = Yii::app()->sysCompany->getClientCompanies();

            ?>                
                <h2><?php echo UserModule::t('Sys companies'); ?></h2>

            <?php 

            $aUserCompanies = CcucUserCompany::model()->getUserCompnies($model->id,CcucUserCompany::CCUC_STATUS_SYS);
            $aChecked = array();
            foreach($aUserCompanies as $UC){
                $aChecked[] = $UC->ccuc_ccmp_id;
            }


            if (count($aChecked) == 1){
                //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
                $aChecked = $aChecked[0];
            }

            $list = array();
            if(UserModule::isAdmin()){
                //for admin get all sys companies
                $criteria = new CDbCriteria;
                $criteria->compare('t.ccxg_ccgr_id', 1); //1 - syscompany
                $model_ccxg = CcxgCompanyXGroup::model()->findAll($criteria);                
                foreach ($model_ccxg as $mCcxg) {
                    $list[$mCcxg->ccxg_ccmp_id] = $mCcxg->ccxgCcmp->ccmp_name;
                }            

            }else{
                //get user sys companies
                foreach ($companies_list as $mCcmp) {
                    $list[$mCcmp->ccucCcmp->ccmp_id] = $mCcmp->ccucCcmp->ccmp_name;
                }            
            }

            echo CHtml::checkBoxList(
                    'user_sys_ccmp_id', 
                    $aChecked, 
                    $list,
                    array ( 'labelOptions'=>array('style'=>'display: inline'))
                    );

    ?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>UserModule::t("Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('#user-rolls').submit();",
                       ),
                    )); 
                    ?>
                  
        </div>
    </div>
</div>                
    
<?php $this->endWidget(); ?>
</div>
</div>
