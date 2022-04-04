<?php namespace mww\Movie\Models;

use Model;

/**
 * Model
 */
class Actor extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var array Generate slugs for these attributes.
     */

    protected $slugs = ['actor_slug' => ['actor_first_name' , 'actor_last_name']];

    public function beforeSave()
    {
        // Force creation of slug
        if (empty($this->actor_slug)) {
            unset($this->actor_slug);
            $this->setSluggedValue('actor_slug','actor_first_name' . 'actor_last_name');
        }
    }


    public $belongsToMany = [
        'movies' => [
            'mww\Movie\Models\Movie',
            'table' => 'mww_movie_actor_pivot',
            'order' => 'movie_title'
        ]
    ];

    public function getFullNameAttribute(){
        return $this->actor_first_name . " " . $this->actor_last_name ;
    }

    
    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'mww_movie_actor';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
