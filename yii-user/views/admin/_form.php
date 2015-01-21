<div class="crud-form">

    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    echo $form->errorSummary($model);
    ?>

    <div class="row">
        <div class="span12">
            <div class="form-horizontal">	
                <div class="control-group">
                    <div class='control-label'>
<?php ?>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-placement="right">
<?php echo $form->errorSummary(array($model, $profile)); ?>                            
                        </span>
                    </div>
                </div>
                <div class="control-group">
                    <div class='control-label'>
<?php echo $form->labelEx($model, 'username'); ?>
                    </div>
                    <div class='controls'>
                        <?php echo $form->textField($model, 'username', array(
                            'size' => 30, 
                            'maxlength' => 128,
                            'autocomplete' => 'off',
                            )
                                ); ?>
                        <?php echo $form->error($model, 'username'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class='control-label'>
<?php echo $form->labelEx($model, 'password'); ?>
                    </div>
                    <div class='controls'>
                        <?php echo $form->passwordField($model, 'password', array(
                            'size' => 60, 
                            'maxlength' => 128,
                            'autocomplete' => 'off',
                            )); ?>
<?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class='control-label'>
<?php echo $form->labelEx($model, 'email'); ?>
                    </div>
                    <div class='controls'>
                        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
<?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>
<?php if (FALSE) { ?>
                    <div class="control-group">
                        <div class='control-label'>
    <?php echo $form->labelEx($model, 'superuser'); ?>
                        </div>
                        <div class='controls'>            
                            <?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
    <?php echo $form->error($model, 'superuser'); ?>
                        </div>
                    </div>
<?php } ?>
                <div class="control-group">
                    <div class='control-label'>
<?php echo $form->labelEx($model, 'status'); ?>
                    </div>
                    <div class='controls'>            
                        <?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
<?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <?php
                $profileFields = Profile::getFields();
                if ($profileFields) {
                    foreach ($profileFields as $field) {
                        ?>
                        <div class="control-group">
                            <div class='control-label'>
        <?php echo $form->labelEx($profile, $field->varname); ?>
                            </div>
                            <div class='controls'>            
                                <?php
                                if ($widgetEdit = $field->widgetEdit($profile)) {
                                    echo $widgetEdit;
                                } elseif ($field->range) {
                                    echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                } elseif ($field->field_type == "TEXT") {
                                    echo CHtml::activeTextArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                                } else {
                                    echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                                }
                                ?>
        <?php echo $form->error($profile, $field->varname); ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <div class="alert">
                    <?php
                    echo UserModule::t('Fields with <span class="required">*</span> are required.');
                    ?>
                </div>
<?php $this->endWidget(); ?>

            </div><!-- form -->