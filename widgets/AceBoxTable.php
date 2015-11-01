<?php

class AceBoxTable extends CWidget {
 
    public $header_color = 'header-color-blue2';
    public $header_icon_class = '';
    public $header_text = '';
    public $toolbar = '';
    public $tableHead = [];
    public $body = '';
 
    public function run() {
        $this->render('aceBoxTable',array(
            'header_color' => $this->header_color,
            'header_icon_class' => $this->header_icon_class,
            'header_text' => $this->header_text,
            'toolbar' => $this->toolbar,
            'tableHead' => $this->tableHead,
            'body' => $this->body,
        ));
    }
 
}