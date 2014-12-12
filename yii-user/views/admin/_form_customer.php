<div class="crud-form">

    <?php
    Yii::app()->bootstrap->registerPackage('select2');
    Yii::app()->clientScript->registerScript('crud/variant/update', '$("#user-form select").select2();');

    $form = $this->beginWidget('TbActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    echo CHtml::hiddenField('user_type' , 'customer');
    echo $form->errorSummary($model);
    ?>

    <div class="row">
        <div class="span12">
            <div class="form-horizontal">	
                <div class="control-group">
                    <div class='control-label'>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-placement="right">
                            <?php echo $form->errorSummary(array($model, $profile)); ?>                            
                        </span>
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

                <?php
                $profileFields = Profile::getFields();
                if ($profileFields) {
                    foreach ($profileFields as $field) {
                        //show only first name and last name
                        if ($field->varname != 'first_name' && $field->varname != 'last_name') {
                            continue;
                        }
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
                                echo $form->error($profile, $field->varname);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }

                ?>
                <div class="control-group">
                    <div class='control-label'>
                        <?php echo $form->labelEx($model, 'ccmp_id'); ?>
                    </div>
                    <div class='controls'>
                        <?php
                        echo $form->dropDownList(
                                $model, 'ccmp_id', CHtml::listData(CcmpCompany::model()->findAll(array('order' => 'ccmp_name')), 'ccmp_id', 'itemLabel')
                                , array(
                            'class' => 'span3'
                                )
                        );
                        echo $form->error($model, 'ccmp_id'); 
                        ?>
                    </div>
                </div>
                <div class="alert">
                    <?php echo UserModule::t('Fields with <span class="required">*</span> are required.');?>
                </div>
                    <?php $this->endWidget(); ?>

            </div><!-- form -->