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

/* This function allows New actor names to be typed into the Actorbox.
    Compare the entered value with values in the database.
    If the actor already exists, then it is selected from the drop down Select field.
    If it does NOT exists, it is added to the database, create new array of actor_id and then added that array to the movie_actor_pivot
    table
    */

    public function getSaveValue($actors) {

            $newArray = [] ;

            foreach($actors as $actorNewData) {

                if (!is_numeric($actorNewData) ) {
                // Create a new actor instance    
                    $newActor = new Actor ;

                    $new_names_array = explode(' ',$actorNewData) ;
                    //dd($new_names_array);
                // Populate fields in the new instance with data from the form    
                    $newActor-> actor_first_name    = $new_names_array[0] ;
                    $newActor-> actor_last_name     = $new_names_array[1];
                // Save the new Actor instance to the Actor model
                    $newActor->save() ;
                // Add the new ID of this new instance to the newArray    
                    $newArray[] = $newActor-> id ; 
                //dd($newActor->id) ;
                }
                else {
                // Add existing actor ID to newArray
                    $newArray[] = $actorNewData ;
                }
            }
            //dd($newArray) ; 
            return $actors ;
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