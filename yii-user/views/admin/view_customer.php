<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php 
        $this->widget("bootstrap.widgets.TbButton", array(
            "icon" => "chevron-left",
            "size" => "large",
            "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/customerAdmin"),
            "htmlOptions" => array(
                "class" => "search-button",
                "data-toggle" => "tooltip",
                "title" => UserModule::t("User List"),
            )
        ));
        ?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-user"></i>
                <?php echo UserModule::t('View Customer User'); ?>
            </h1>
        </div>
        <div class="btn-group">
            <?php
                
                if (Yii::app()->user->checkAccess("audittrail") 
                    && isset($this->module->options['audittrail'])
                    && $this->module->options['audittrail'])
                {
                    Yii::import('audittrail.*');
                    $this->widget("vendor.dbrisinajumi.audittrail.widgets.AudittrailViewTbButton",array(
                        'model_name' => get_class($model),
                        'model_id' => $model->getPrimaryKey(),
                    ));                        

                }
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t("Invite or Reset password by email"),
                    'type' => TbButton::TYPE_WARNING,
                    "size" => "large",
                    "url" => array('emailInvitation', 'id' => $model->getPrimaryKey()),
                ));                
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t("Delete"),
                    "icon"=>"icon-remove icon-white",
                    'type' => TbButton::TYPE_DANGER,
                    "size" => "large",
                    "url" => array('deleteCustomer', 'id' => $model->getPrimaryKey()),
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
            array(
                'name' => 'username',
                'type' => 'raw',
                'value' => $this->widget(
                    'EditableField',
                    array(
                        'model' => $model,
                        'url' => $this->createUrl('/user/admin/editableSaver'),
                        'attribute' => 'username',
                        //'placement' => 'right',
                    ),
                    true
                )
            ),            
        );

        $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
        if ($profileFields) {
            foreach ($profileFields as $field) {
                if ($field->varname != 'first_name' && $field->varname != 'last_name') {
                    continue;
                }                
                array_push($attributes, array(
                    'label' => UserModule::t($field->title),
                    'name' => $field->varname,
                    'type' => 'raw',
                    'value' => (($field->widgetView($model->profile)) ? $field->widgetView($model->profile) : (($field->range) ? Profile::range($field->range, $model->profile->getAttribute($field->varname)) : $model->profile->getAttribute($field->varname))),
                ));
            }
        }

        array_push($attributes,
                    array(
                        'name' => 'email',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'url' => $this->createUrl('/user/admin/editableSaver'),
                                'attribute' => 'email',
                                //'placement' => 'right',
                            ),
                            true
                        )
                    ),            
                    array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'type' => 'select',
                                'url' => $this->createUrl('/user/admin/editableSaver'),
                                'source' => Editable::source(array(
                                    User::STATUS_ACTIVE => User::itemAlias("UserStatus", User::STATUS_ACTIVE), 
                                    User::STATUS_NOACTIVE => User::itemAlias("UserStatus", User::STATUS_NOACTIVE), 
                                    )),
                                'attribute' => 'status',
                                //'placement' => 'right',
                            ),
                            true
                        )
                    )            
        );
        $defaultDetailView = Yii::app()->getModule('user')->defaultDetailView;
        $this->widget($defaultDetailView['path'], $defaultDetailView['options'] + array(
            'data' => $model,
            'attributes' => $attributes,
        ));
        ?>
        <div class="btn-toolbar pull-left">
            <div class="btn-group"><?php
                $this->widget("bootstrap.widgets.TbButton", array(
                    "icon" => "chevron-left",
                    "size" => "large",
                    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/customerAdmin"),
                    "htmlOptions" => array(
                        "class" => "search-button",
                        "data-toggle" => "tooltip",
                        "title" => UserModule::t("User List"),
                    )
                ));            
            ?></div>
        </div>        
    </div>
    <div class="span8">
    <?php        
  		$this->renderPartial($companies_view,array(
            'model' => $model,
            'ajax' => false,
		));
        
    ?>
    </div>
</div>