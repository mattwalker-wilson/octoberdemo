<?php namespace mww\Movie\FormWidgets;

use Backend\Classes\FormWidgetBase;
use mww\Movie\Models\Movie;
use Config;

class Actorbox extends FormWidgetBase {

    public function widgetDetails() {

        return [
            'name' => 'Actorbox',
            'description' => 'Field for adding actors names and details'
        ];
    }

    public function render(){
        return $this->makePartial('widget');
    }

    public function loadAssets() 
    {
        $this->addCss('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        $this->addJs('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
    }


/*
    public function registerSettings() {

    }

*/
}