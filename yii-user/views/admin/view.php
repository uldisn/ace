<?php
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => UserModule::t("User List"),
    )
        ), true);
    
?>    
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-user"></i>
                <?php echo UserModule::t('View User'); ?>
            </h1>
        </div>
        <div class="btn-group">
            <?php
                
                if (Yii::app()->user->checkAccess("audittrail") 
                    && isset($this->module->options['audittrail'])
                    && $this->module->options['audittrail'])
                {
                    Yii::import('audittrail.*');
                    $this->widget('EFancyboxWidget',array(
                        'selector'=>'a[href*=\'audittrail/show/fancybox\']',
                        'options'=>array(
                        ),
                    ));        
                    $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>UserModule::t("Audit Trail"),
                        'type'=>'info',
                        "size"=>"large",
                        "url"=>array(
                            '/audittrail/show/fancybox',
                            'model_name' => get_class($model),
                            'model_id' => $model->getPrimaryKey(),
                        ),
                        "icon"=>"icon-info-sign",
                    ));                        

                }
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t("Invite or Reset password by email"),
                    'type' => TbButton::TYPE_WARNING,
                    "size" => "large",
                    "url" => array('emailInvitation', 'id' => $model->getPrimaryKey()),
                ));                
                
            ?>
        </div>
    </div>
</div>



    <?php 
    if (isset($_GET['sent']) && $_GET['sent'] == 'ok'){
    ?>
<div class="row">
    <div class="span9 alert alert-block alert-success">
        <button data-dismiss="alert" class="close" type="button">
			<i class="icon-remove"></i>
		</button>
        <?php echo UserModule::t("New password sent to email.");?>
    </div>
</div>
    <?php 
    }
    if (isset($_GET['sent']) && $_GET['sent'] == 'error'){
    ?>
<div class="row">
    <div class="span9 alert alert-block alert-warning">
        <button data-dismiss="alert" class="close" type="button">
			<i class="icon-remove"></i>
		</button>
        <?php echo UserModule::t("Failed to send password to the e mail.");?>
    </div>
</div>
    <?php 
    }    
    ?>
<div class="row">
    <div class="span4">
        <?php
        $attributes = array(
            'id',
            'username',
        );

        $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
        if ($profileFields) {
            foreach ($profileFields as $field) {
                array_push($attributes, array(
                    'label' => UserModule::t($field->title),
                    'name' => $field->varname,
                    'type' => 'raw',
                    'value' => (($field->widgetView($model->profile)) ? $field->widgetView($model->profile) : (($field->range) ? Profile::range($field->range, $model->profile->getAttribute($field->varname)) : $model->profile->getAttribute($field->varname))),
                ));
            }
        }

        array_push($attributes,
                //'password',
                'email', 'create_at', 'lastvisit_at', array(
            'name' => 'status',
            'value' => User::itemAlias("UserStatus", $model->status),
                )
        );
        $defaultDetailView = Yii::app()->getModule('user')->defaultDetailView;
        $this->widget($defaultDetailView['path'], $defaultDetailView['options'] + array(
            'data' => $model,
            'attributes' => $attributes,
        ));
        ?>
        <div class="btn-toolbar pull-left">
            <div class="btn-group"><?php echo $cancel_buton; ?></div>
        </div>        
    </div>
    <div class="span5"> <!-- main inputs -->
        <?php
        $form = $this->beginWidget('CActiveForm', array('id' => 'user-rolls'));
        /**
         * ROLES
         */
        $aChecked = Authassignment::model()->getUserRoles($model->id);
        $admin_role = Yii::app()->getModule('rights')->superuserName;
        if (in_array($admin_role, $aChecked)) {
            $info_allert = array(
                UserModule::t('For administrator can not save changes of roles'),
            );
            $body = '';
        } else {
            $info_allert = array();

            $aChecked = Authassignment::model()->getUserRoles($model->id);
            if (count($aChecked) == 1) {
                //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
                $aChecked = $aChecked[0];
            }
            $UserAdminRoles = Yii::app()->getModule('user')->UserAdminRoles;
            $list = array();
            foreach ($UserAdminRoles as $role_name) {
                $list[$role_name] = Yii::t('roles', $role_name);
            }
            $body = CHtml::checkBoxList(
                            'user_role_name', $aChecked, $list, array(
                        'labelOptions' => array(
                            'style' => 'display: inline',
                        ),
                        'template' => '{input}<span class="lbl"></span> {label}',
                        'class' => 'ace',
                            )
            );
        }

        $this->widget('AceBox', array(
            'header_text' => UserModule::t('Roles'),
            'info_allert' => $info_allert,
            'body' => $body,
        ));

        $companies_list = Yii::app()->sysCompany->getClientCompanies();
        $aUserCompanies = CcucUserCompany::model()->getUserCompnies($model->id, CcucUserCompany::CCUC_STATUS_SYS);
        $aChecked = array();
        foreach ($aUserCompanies as $UC) {
            $aChecked[] = $UC->ccuc_ccmp_id;
        }


        if (count($aChecked) == 1) {
            //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
            $aChecked = $aChecked[0];
        }

        $list = array();
        if (UserModule::isAdmin()) {
            //for admin get all sys companies
            $sql = "
                    SELECT 
                        ccmp_id,
                        ccmp_name 
                      FROM
                        ccxg_company_x_group 
                        INNER JOIN ccmp_company 
                          ON ccxg_ccmp_id = ccmp_id 
                      WHERE ccxg_ccgr_id = " . Yii::app()->params['ccgr_group_sys_company'] . " 
                      ORDER BY ccmp_name";
            $ccmp_list = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($ccmp_list as $ccmp) {
                $list[$ccmp['ccmp_id']] = $ccmp['ccmp_name'];
            }
        } else {
            //get user sys companies
            foreach ($companies_list as $mCcmp) {
                $list[$mCcmp['ccmp_id']] = $mCcmp['ccmp_name'];
            }
        }

        $body = CHtml::checkBoxList(
                        'user_sys_ccmp_id', $aChecked, $list, array(
                    'labelOptions' => array(
                        'style' => 'display: inline',
                    ),
                    'template' => '{input}<span class="lbl"></span> {label}',
                    'class' => 'ace',
                        )
        );

        $this->widget('AceBox', array(
            'header_text' => UserModule::t('Sys companies'),
            'body' => $body,
        ));

        /**
         * IP Tables
         */
        $security_policy = Yii::app()->getModule('user')->SecurityPolicy;

        if ($security_policy['useIpTables']) {

            $aChecked = UxipUserXIpTable::model()->getUserIpTables($model->id);
            $Iptb_list = IptbIpTable::model()->findAll();

            $list = array();
            foreach ($Iptb_list as $Iptb) {
                $list[$Iptb['iptb_id']] = Yii::t('roles', $Iptb['iptb_name']);
            }

            $body = CHtml::checkBoxList(
                            'ip_tables', $aChecked, $list, array(
                        'labelOptions' => array(
                            'style' => 'display: inline',
                        ),
                        'template' => '{input}<span class="lbl"></span> {label}',
                        'class' => 'ace',
                            )
            );

            $this->widget('AceBox', array(
                'header_text' => UserModule::t('IP Tables'),
                'body' => $body,
            ));
        }
        ?>    

        <div class="btn-toolbar pull-left">
            <div class="btn-group">

                <?php
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t("Save"),
                    "icon" => "icon-thumbs-up icon-white",
                    "size" => "large",
                    "type" => "primary",
                    "htmlOptions" => array(
                        "onclick" => "$('#user-rolls').submit();",
                    ),
                    "visible" => Yii::app()->user->checkAccess("UserAdmin")
                ));
                ?>

            </div>
        </div>


        <?php 
        $this->endWidget();

        if (Yii::app()->user->checkAccess("UserAdmin")) {
            $code_card = Yii::app()->getModule('user')->codeCard;
            if (!empty($code_card['host']) && !empty($code_card['apy_key']) && !empty($code_card['crypt_key'])) {
                if ($model->profile->getAttribute('code_card_expire_date')) {
                    $button_text = 'Regenerate';
                    $button_class = 'btn-warning';
                    $button_icon = 'icon-refresh';
                    $button_action = 'change_card';
                } else {
                    $button_text = 'Generate';
                    $button_class = 'btn-success';
                    $button_icon = 'icon-plus';
                    $button_action = 'create_card';
                }

                $body = $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t($button_text),
                    "icon" => $button_icon,
                    "size" => "large",
                    "type" => "primary",
                    "url" => array(
                        "genCodeCard",
                        'id' => $model->id,
                        'request_type' => $button_action
                    ),
                    "htmlOptions" => array(
                        "class" => $button_class,
                    )
                        ), true);
                $this->widget('AceBox', array(
                    'header_icon_class' => 'icon-lock',
                    'header_text' => UserModule::t('Code Card'),
                    'body' => $body,
                ));
                ?>
            </div>
            <?php
        }
    }
    ?>
</div>