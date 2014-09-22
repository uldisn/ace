<?php

class TbAceDetailView extends CDetailView
{

    public $tagName = 'div';
    public $htmlOptions = array('class'=>'profile-user-info profile-user-info-striped');
    public $itemTemplate = '
                <div class="profile-info-row"><div class="profile-info-name">{label}</div>
                <div class="profile-info-value">{value}</div></div>';
    public $label_width = 120;

	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

 	public function init()
	{
		parent::init();
        
        Yii::app()->clientScript->registerCss($this->id.'fix_detail_view', ' 
            #'.$this->id.' .profile-info-name {width: '.$this->label_width.'px;}
            #'.$this->id.' .profile-info-value {margin-left: '.$this->label_width.'px;}
        ');        
        
        foreach($this->attributes as $k => $attribute)
		{
            if(!isset($attribute['external_link'])){
                continue;
            }
            if(empty($attribute['value_id'])){
                continue;
            }
            $this->attributes[$k]['value'] .=  '&nbsp;'
                    .CHtml::link(
                            '<i class="icon-external-link"></i>',
                            $attribute['external_link'],
                            array(
                                'target'=>'_blank',
                                'title'=>$attribute['external_title'],
                                'data-toggle'=>'tooltip',
                                )
                            );
        }            
        

	}
   
    
    
}
