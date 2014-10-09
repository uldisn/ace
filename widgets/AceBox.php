<?php

class AceBox extends CWidget {
 
    public $header_icon_class = '';
    public $header_text = '';
    public $body = '';
    public $info_allert = array();
    public $error_allert = array();
    public $warning_allert = array();
 
    public function run() {
        $this->render('aceBox',array(
            'header_icon_class' => $this->header_icon_class,
            'header_text' => $this->header_text,
            'info_allert' => $this->info_allert,
            'error_allert' => $this->error_allert,
            'warning_allert' => $this->warning_allert,
            'body' => $this->body,
        ));
    }
 
}