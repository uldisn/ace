<?php

class TimeTable extends CWidget {

    const FREQ_DAILY = 'DAILY';
    const FREQ_WEEKLY = 'WEEKLY';
    const FREQ_MONTLY = 'MONTLY';

    public $frquency = self::FREQ_DAILY;
    
    /**
     * header display date format
     * @var type 
     */
    public $date_format = 'Y.m.d';
    
    /**
     * records of body data:
     * record format: [
     *    'start_date' => '2014.01.01',
     *    'end_date' => '2014.01.11',
     *    'end_date' => '2014.01.11',
     *    'label' => 'Truck AA1111',
     *    'label' => 'Truck AA1111',
     *    'icon' => 'icon-question', 
     *    'color' => 'yellow',
     * @var type 
     */
    public $body_data;
    
    /**
     * time table start date 
     * format yyyy-mm-dd
     * @var date 
     */
    public $date_from;
    
    /**
     * time table end date 
     * format yyyy-mm-dd
     * @var date 
     */    
    public $date_to;
    
     /**
     * header dates 
     * format yyyy-mm-dd
     * @var date 
     */
    public $header = [];
    
    /**
     * define urls for: period_prev,period_next,period_today
     * @var arrau
     */
    public $header_urls;
    
    /**
     * header labels: title, today
     * @var array 
     */
    public $header_labels;

    public function init() {

        $this->registreCss();
        if (empty($this->header)) {
            $this->fill_header();
        }
    }

    public function registreCss() {
        $ace_path = Yii::app()->params['ace_assets'];
        $asset_link = Yii::app()->assetManager->publish($ace_path, false, -1, false);
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($asset_link . '/css/fullcalendar.css');
        
        //in cels text align to left
        Yii::app()->clientScript->registerCss('WidgetTimeTable','.fc-content a.btn{text-align: left;}');
    }

    public function fill_header() {
        if ($this->frquency == self::FREQ_DAILY) {
            $this->header[] = $this->date_from;

            $date = new DateTime($this->date_from);
            $date_to = new DateTime($this->date_to);
            $i = 0;
            do {

                $date->modify('+1 day');
                $this->header[] = $date->format('Y-m-d');
                $i ++;
                if ($i > 1000)
                    break;
            }while ($date_to >= $date);
            return true;
        }
    }

    public function run() {
        $this->render('time_table', array(
            'header' => $this->header,
            'body_data' => $this->body_data,
            'urls' => $this->header_urls,
            'header_labels' => $this->header_labels,
            'date_format' => $this->date_format,
        ));
    }

}
