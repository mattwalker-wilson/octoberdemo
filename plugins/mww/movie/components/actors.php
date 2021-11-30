<?php 
namespace mww\movie\components ;

use Cms\Classes\ComponentBase;
use mww\Movie\Models\Actor;

class Actors extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Actor List',
            'description' => 'A component that displays a list of all the actors.'
        ];
    }

    protected function loadActors() {
        $query = Actor::all() ;
        if ( $this->property('sortDirection') == 'asc') {
            $query =  $query->sortBy($this->property('sortField') ) ;
        } 
        else {
            $query =  $query->sortByDesc($this->property('sortField') ) ;
        }
        
        if ($this->property('results') > 0 ) {
            $query = $query->take($this->property('results')) ;
        }
        return $query ;
    }

    public function defineProperties() {
        return [
            'results'       => [
                'title'             => 'Number of Actors' ,
                'description'       => 'How many actors do you want to display? (0 = ALL)' ,
                'default'           => 0 ,
                'validationPattern' => '^[0-9]+$' ,
                'validationMessage' => 'Must be a whole number. 0 = display all.'
            ] ,
            'sortField'     => [
                    'title'         =>  'Sort by' ,
                    'description'   =>  'What field to sort by.' ,
                    'type'          =>  'dropdown' ,
                    'default'       =>  'actor_last_name'
            ] ,
            'sortDirection' => [
                    'title'         =>  'Ascending/Descending' ,
                    'description'   =>  'Sorted by Ascending or Descending order' ,
                    'type'          =>  'dropdown' ,
                    'default'       =>  'asc'
            ]
        ];
    }

    public function getSortFieldOptions() {
        return [
            'actor_last_name'   => 'Last Name' ,
            'actor_first_name'  => 'First Name' ,
            'actor_dob'         => 'Date of Birth'
        ] ;
    }

    public function getSortDirectionOptions() {
        return [
            'asc'   => 'Ascending' ,
            'desc'  => 'Descending'
        ] ;
    }

    public function onRun() {
        $this->allActorsList = $this->loadActors() ;
        # $this->allActorsList = Actor::all() ;
    }

    public $allActorsList ;
}