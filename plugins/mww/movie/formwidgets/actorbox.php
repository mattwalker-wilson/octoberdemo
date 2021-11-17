<?php namespace mww\Movie\FormWidgets;

use Backend\Classes\FormWidgetBase;
use mww\Movie\Models\Movie;
use mww\Movie\Models\Actor;
use Config;

class Actorbox extends FormWidgetBase {

    public function widgetDetails() {

        return [
            'name' => 'Actorbox',
            'description' => 'Field for adding actors names and details'
        ];
    }

    public function render(){
        $this->prepareVars();
        //dump( $this->vars['selectedValues'] ) ;
        return $this->makePartial('widget');
    }

    public function prepareVars(){
        $this->vars['id']               = $this->model->id;
        $this->vars['rsAllActors']      = Actor::all()->lists('full_name','id');
        $this->vars['selectfieldname']  = $this->formField->getName().'[]';
        if (!empty($this->getLoadValue())) {
            $this->vars['selectedValues']   = $this->getLoadValue();
        }
        else {
            $this->vars['selectedValues'] = [];
        }
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