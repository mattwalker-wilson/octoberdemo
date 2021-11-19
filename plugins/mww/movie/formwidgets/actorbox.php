<?php namespace mww\Movie\FormWidgets;

use Backend\Classes\FormWidgetBase;

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
        
        // OctoberCMS knows what the field name is with getName 
        // and getName().[] returns an array of names.
        // "Movie.actors[]"
        $this->vars['selectfieldname']  = $this->formField->getName().'[]';
        
        // If the recordset of actors is Not Empty, display the LoadValue
        if (!empty($this->getLoadValue())) {
            $this->vars['selectedValues']   = $this->getLoadValue();
        }
        else {
        // else the record set of Actors is empty, display an empty array
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