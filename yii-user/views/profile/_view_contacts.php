<div class="table-header">
    <?php
    echo Yii::t('D2personModule.model', 'Ppcn Person Contact');

    $pprs_id = Yii::app()->getModule('user')->user()->profile->person_id;


    $this->widget(
            'bootstrap.widgets.TbButton', array(
        'buttonType' => 'ajaxButton',
        'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'mini',
        'icon' => 'icon-plus',
        'url' => array(
            '//d2person/ppcnPersonContact/ajaxCreate',
            'field' => 'ppcn_pprs_id',
            'value' => $pprs_id,
            'ajax' => 'ppcn-person-contact-grid',
        ),
        'ajaxOptions' => array(
            'success' => 'function (html) {$.fn.yiiGridView.update(\'ppcn-person-contact-grid\');}'
        ),
        'htmlOptions' => array(
            'title' => Yii::t('D2personModule.crud_static', 'Add new record'),
            'data-toggle' => 'tooltip',
        ),
            )
    );
    ?>
</div>

<?php
//if no contacts, add empty record
$model = PpcnPersonContact::model()->findByAttributes(array('ppcn_pprs_id' => $pprs_id));
if (empty($model)) {
    $model = new PpcnPersonContact;
    $model->ppcn_pprs_id = $pprs_id;
    $model->save();
    unset($model);
}

$model = new PpcnPersonContact();
$model->ppcn_pprs_id = $pprs_id;

// render grid view
$this->widget('TbGridView', array(
    'id' => 'ppcn-person-contact-grid',
    'dataProvider' => $model->search(),
    'template' => '{summary}{items}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ppcn_pcnt_type',
            'editable' => array(
                'type' => 'select',
                'url' => $this->createUrl('//d2person/ppcnPersonContact/editableSaver'),
                'source' => CHtml::listData(PcntContactType::model()->findAll(array('limit' => 1000)), 'pcnt_id', 'itemLabel'),
                'placement' => 'right',
            )
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ppcn_value',
            'editable' => array(
                'url' => $this->createUrl('//d2person/ppcnPersonContact/editableSaver'),
            )
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ppcn_notes',
            'editable' => array(
                'type' => 'textarea',
                'url' => $this->createUrl('//d2person/ppcnPersonContact/editableSaver'),
            ),
        ),
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'FALSE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'TRUE'),
            ),
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/d2person/ppcnPersonContact/delete", array("ppcn_id" => $data->ppcn_id))',
            'deleteConfirmation' => Yii::t('D2personModule.crud_static', 'Do you want to delete this item?'),
            'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
            'visible' => Yii::app()->user->checkAccess("D2person.PpcnPersonContact.Delete"),
        ),
    )
        )
);