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
	<div class="span6">


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
                $list[$role_name] = Yii::t('roles', $role_name);
                //$list[$role_name] = $role_name;
            }
            echo CHtml::checkBoxList(
                    'user_role_name', 
                    $aChecked, 
                    $list,
                    array ( 
                        'labelOptions'=>array(
                            'style'=>'display: inline',
                            ),
                        'template' => '{input}<span class="lbl"></span> {label}',
                        'class' => 'ace',
                        )
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
                $sql = "
                    SELECT 
                        ccmp_id,
                        ccmp_name 
                      FROM
                        ccxg_company_x_group 
                        INNER JOIN ccmp_company 
                          ON ccxg_ccmp_id = ccmp_id 
                      WHERE ccxg_ccgr_id = ".Yii::app()->params['ccgr_group_sys_company']." 
                      ORDER BY ccmp_name";
                $ccmp_list = Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($ccmp_list as $ccmp) {
                    $list[$ccmp['ccmp_id']] = $ccmp['ccmp_name'];
                }            

            }else{
                //get user sys companies
                foreach ($companies_list as $mCcmp) {
                    $list[$mCcmp['ccmp_id']] = $mCcmp['ccmp_name'];
                }            
            }

            echo CHtml::checkBoxList(
                    'user_sys_ccmp_id', 
                    $aChecked, 
                    $list,
                    array ( 
                        'labelOptions'=>array(
                            'style'=>'display: inline',
                            ),
                        'template' => '{input}<span class="lbl"></span> {label}',
                        'class' => 'ace',
                        )
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
                        "visible" => Yii::app()->user->checkAccess("UserAdmin")
                    )); 
                    ?>
                  
        </div>
    </div>
</div>                
    
<?php $this->endWidget(); ?>
                
<?php
if (Yii::app()->user->checkAccess("UserAdmin")) {
    $code_card = Yii::app()->getModule('user')->codeCard;
    if (!empty($code_card['host']) && !empty($code_card['apy_key']) && !empty($code_card['crypt_key'])) {
        ?>
        <h2><i class="icon-lock"></i> <?php echo UserModule::t('Code Card'); ?></h2>
        <div class="clearfix">
            <div class="btn-toolbar pull-left">
                <div class="btn-group">

                    <?php
                    
                        if ($model->profile->getAttribute('code_card_expire_date')) {
                            $button_text   = 'Regenerate';
                            $button_class  = 'btn-warning';
                            $button_icon   = 'icon-refresh';
                            $button_action = 'change_card';
                        } else {
                            $button_text   = 'Generate';
                            $button_class  = 'btn-success';
                            $button_icon   = 'icon-plus';
                            $button_action = 'create_card';
                        }
                        
                        $this->widget("bootstrap.widgets.TbButton", array(
                            "label"=>UserModule::t($button_text),
                            "icon"=>$button_icon,
                            "size"=>"large",
                            "type"=>"primary",
                            "url"=>array(
                                "genCodeCard",
                                'id' => $model->id,
                                'request_type' => $button_action
                            ),
                            "htmlOptions"=> array(
                                "class" => $button_class,
                            )
                        ));
                    ?>

                </div>
            </div>
        </div>
        
        <?php
    }
}

?>
</div>
</div>
