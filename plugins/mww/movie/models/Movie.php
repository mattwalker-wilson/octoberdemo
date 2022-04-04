<?php namespace mww\Movie\Models;
use Model;
/**
 * Model
 */
class Movie extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Sortable;
    
    /**
     * @var array Generate slugs for these attributes.
     */

    protected $slugs = ['actor_slug' => ['movie_title']];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'mww_movie_';

    protected $jsonable = ['actors'];

    /** 
     * 
     * Relationships 
     */
    public $attachOne = [
         'movie_poster' => 'System\Models\File'
    ];

    public $attachMany = [
        'movie_gallery' => 'System\Models\File'
    ];

    public $belongsToMany = [
        'genres' => [
            'mww\Movie\Models\Genre',
            'table' => 'mww_movie_genre_pivot',
            'order' => 'genre_title'
        ],
        'actors' => [
            'mww\Movie\Models\Actor',
            'table' => 'mww_movie_actor_pivot',
            'order' => 'actor_last_name'
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
