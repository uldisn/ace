<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Profile");
?>

<div class="page-header position-relative">
    <div class="clearfix">
        <div class="btn-toolbar pull-left">
            <div class="btn-group">
                <h1>
                    <i class="icon-user"></i>
                    <?php echo UserModule::t('Your profile') ?>
                </h1>
            </div>
        </div>
    </div>
</div>    

<div class="row-fluid">
    <div class="span4">
        <?php
        $attributes = array(
            //'id',
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
        //var_dump($attributes);exit;
        $defaultDetailView = Yii::app()->getModule('user')->defaultDetailView;
        $this->widget($defaultDetailView['path'], $defaultDetailView['options'] + array(
            'data' => $model,
            'attributes' => $attributes,
        ));
        ?>
    </div>
    
</div>        
<?php
if (Yii::app()->hasModule('d2person')) {
?>
<div class="space-12"></div>
    <div class="row-fluid">
        <div class="span7">
            <?php
            $view = Yii::app()->getModule('user')->view . '.profile._view_contacts';
            $this->renderPartial($view);
            ?>
        </div>

    </div>
<?php
}

if (Yii::app()->hasModule('d2files') ) {
?>
<div class="space-12"></div>
    <div class="row-fluid">
        <div class="span7">
            <?php
            $pprs_id = Yii::app()->getModule('user')->user()->profile->person_id;
            $pprs_model = PprsPerson::model()->findByPk($pprs_id);
            if(empty($pprs_model)){
                ?>
                    <div class="alert alert-warning">
                        <strong>Warning!</strong>
                        Can not find person data record!
                    </div>                    
                <?php
            }else{
                $this->widget('d2FilesWidget',array('module'=>'d2person', 'model'=>$pprs_model));
            }
            ?>
        </div>

    </div>
<?php
}
