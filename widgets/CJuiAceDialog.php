<?php
/**
 * CJuiDialog class file.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * CJuiDialog displays a dialog widget.
 *
 * CJuiDialog encapsulates the {@link http://jqueryui.com/dialog/ JUI Dialog}
 * plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
 *     'id'=>'mydialog',
 *     // additional javascript options for the dialog plugin
 *     'options'=>array(
 *         'title'=>'Dialog box 1',
 *         'autoOpen'=>false,
 *     ),
 * ));
 *
 *     echo 'dialog content here';
 *
 * $this->endWidget('zii.widgets.jui.CJuiDialog');
 *
 * // the link that may open the dialog
 * echo CHtml::link('open dialog', '#', array(
 *    'onclick'=>'$("#mydialog").dialog("open"); return false;',
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI dialog plugin. Please refer to
 * the {@link http://api.jqueryui.com/dialog/ JUI Dialog API} documentation
 * for possible options (name-value pairs) and
 * {@link http://jqueryui.com/dialog/ JUI Dialog page} for general description
 * and demo.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @package zii.widgets.jui
 * @since 1.1
 */
class CJuiAceDialog extends CJuiWidget
{
	/**
	 * @var string the name of the container element that contains all panels. Defaults to 'div'.
	 */
	public $tagName='div';

    
    public $title = '';
    public $title_icon = false;
    
	/**
	 * Renders the open tag of the dialog.
	 * This method also registers the necessary javascript code.
	 */
	public function init()
	{
        //js part
        Yii::app()->clientScript->registerScript('ui_dialog_ace_extend', ' 
				$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
					_title: function(title) {
						var $title = this.options.title || "&nbsp;"
						if( ("title_html" in this.options) && this.options.title_html == true )
							title.html($title);
						else title.text($title);
					}
				}));

            ');
        
        $ace_link = Yii::app()->assetManager->publish(
            Yii::app()->params['ace_assets'], false, // hash by name
            -1, // level
            false); // forceCopy        
        
        $this->scriptUrl = $ace_link.'/js';
        $this->scriptFile = array('jquery.ui.touch-punch.min.js');
        $this->themeUrl = $ace_link;
        $this->theme = 'css';
        $this->cssFile = 'jquery-ui-1.10.3.full.min.css';
        
		parent::init();

        //set id
		$id=$this->getId();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
        
        //options
        $this->options['title'] = $this->createTilte();
        $this->options['title_html'] = true;
        
		$options=CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').dialog($options);");

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
	}
    


	/**
	 * Renders the close tag of the dialog.
	 */
	public function run()
	{
		echo CHtml::closeTag($this->tagName);
	}
    
    public function createTilte(){
        
        $icon = '';
        if($this->title_icon){
            $icon = '<i class="'.$this->title_icon.'"></i>';
        }
        
        return '<div class="widget-header"><h4 class="smaller">'.$icon.$this->title.'</h4></div>';
        
    }
    
}