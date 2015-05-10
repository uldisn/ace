<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', '
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
    Yii::app()->clientScript->registerScript('hide_user_company_grid_header', '
                $("#ccuc-user-company-grid thead").hide();
            ');

?>
<div class="table-header">
    <?= UserModule::t("Customer companies ") ?>
    <?php
    $this->widget(
            'bootstrap.widgets.TbButton', array(
        'buttonType' => 'ajaxButton',
        'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'mini',
        'icon' => 'icon-plus',
        'url' => array(
            "{$this->id}/customerAjaxCompanyAdd",
            'id' => $model->id,
            'pprs_id' => $model->profile->person_id,
            'ajax' => 'ccuc-user-company-grid',
        ),
        'ajaxOptions' => array(
            'success' => 'function (html) {
                $.fn.yiiGridView.update(\'ccuc-user-company-grid\');
                
            }'
        ),
        'htmlOptions' => array(
            'title' => UserModule::t('Add company'),
            'data-toggle' => 'tooltip',
        ),
            )
    );
    ?>
</div>

    <?php
}    
    $ccuc = new CcucUserCompany();
    $ccuc->ccuc_person_id = $model->profile->person_id;
    // render grid view
    $this->widget('TbGridView', array(
        'id' => 'ccuc-user-company-grid',
        'dataProvider' => $ccuc->searchPersonsForRel(),
        'template' => '{summary}{items}',
        'summaryText' => '&nbsp;',
        'enableSorting' => false,
        'htmlOptions' => array(
            'class' => 'rel-grid-view'
        ),
        'afterAjaxUpdate' => 'function(){$("#ccuc-user-company-grid thead").hide()}',
        'columns' => array(
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'ccuc_ccmp_id',
                'value' => '$data->ccmp_name',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//d2company/ccucUserCompany/editableSaver'),
                    'source' => CHtml::listData(CcmpCompany::model()->findAll(array('order' => 'ccmp_name')), 'ccmp_id', 'itemLabel'),
                ),
            ),
            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'FALSE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'TRUE'),
                ),
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/d2company/ccucUserCompany/delete", array("ccuc_id" => $data->ccuc_id))',
                'deleteConfirmation' => UserModule::t('Do you want to delete this item?'),
                'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
            ),
        )
            )
    );
    