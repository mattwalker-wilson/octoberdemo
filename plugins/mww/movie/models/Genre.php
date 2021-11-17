<?php namespace mww\Movie\Models;

use Model;

/**
 * Model
 */
class Genre extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'mww_movie_genre';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /** 
     * 
     * Relationships 
     */
    public $belongsToMany = [
        'movies' => [
            'mww\Movie\Models\Movie',
            'table' => 'mww_movie_genre_pivot',
            'order' => 'movie_title'
            ]
    ];

}
