<?php namespace mww\Movie;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'mww\Movie\Components\Actors' => 'actors', 
            'mww\Movie\Components\Genres' => 'genres'
        ] ;
    }

    public function registerFormWidgets() {
        return [
            'mww\Movie\FormWidgets\Actorbox' => [
                'label' => 'Actorbox Field' ,
                'code'  => 'actorbox'
            ]
        ];
    }

    public function registerSettings()
    {
    }
}
