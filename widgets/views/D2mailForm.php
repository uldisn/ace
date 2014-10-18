<div id="id-message-new-navbar" class="message-navbar align-center clearfix">

    <div class="message-bar">
    <?php 
    //SAVE Draft un Discard iznjemts
    if(false){
    ?>        
        <div class="message-toolbar">
            <a href="#" class="btn btn-mini btn-message">
                <i class="icon-save bigger-125"></i>
                <span class="bigger-110"><?php echo Yii::t('AceModule.d2maillist', 'Save Draft');?></span>
            </a>

            <a href="#" class="btn btn-mini btn-message">
                <i class="icon-remove bigger-125"></i>
                <span class="bigger-110"><?php echo Yii::t('AceModule.d2maillist', 'Discard');?></span>
            </a>
        </div>
    <?php 
    }
    ?>        
    </div>

    <div class="message-item-bar">
        <div class="messagebar-item-left">
            <a href="#" class="btn-back-message-list no-hover-underline">
                <i class="icon-arrow-left blue bigger-110 middle"></i>
                <b class="middle bigger-110"><?php echo Yii::t('AceModule.d2maillist', 'Back');?></b>
            </a>
        </div>

        <div class="messagebar-item-right">
            <span class="inline btn-send-message">
                <button type="button" class="btn btn-small btn-primary no-border">
                    <span class="bigger-110"><?php echo $send_label;?></span>
                    <i class="icon-arrow-right icon-on-right"></i>
                </button>
            </span>
        </div>
    </div>
</div>

<form id="id-message-form" class="form-horizontal message-form">
    <?php 
    if($recipient_html){
        echo $recipient_html;
    }
    ?>

    <div class="control-group">
        <label class="control-label" for="form-field-subject"><?php echo Yii::t('AceModule.d2maillist', 'Subject');?>:</label>

        <div class="controls">
            <span class="input-icon span8">
                <input maxlength="100" type="text" class="span12" name="subject" id="form-field-subject" placeholder="<?php echo Yii::t('AceModule.d2maillist', 'Subject');?>" />
                <i class="icon-comment-alt"></i>
            </span>
        </div>
    </div>

    <div class="hr hr-16 dotted"></div>

    <div class="control-group">
        <label class="control-label">
            <span class="inline space-16 hidden-480"></span>
            <?php echo Yii::t('AceModule.d2maillist', 'Message');?>:
        </label>

        <div class="controls">
            <textarea name="message" class="autosize-transition span12" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>
        </div>
    </div>
    
</form>