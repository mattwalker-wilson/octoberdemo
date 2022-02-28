<?php namespace Database\Tester\Models;

use Model;

class Author extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'database_tester_authors';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'user' => [
            User::class,
            'delete' => true
        ],
        'country' => Country::class,
        'user_soft' => [SoftDeleteUser::class, 'key' => 'user_id', 'softDelete' => true],
    ];

    public $hasMany = [
        'posts' => Post::class,
    ];

    public $hasOne = [
        'phone' => Phone::class,
    ];

    public $belongsToMany = [
        'roles' => [
            Role::class,
            'table' => 'database_tester_authors_roles'
        ],
        'executive_authors' => [
            Role::class,
            'table' => 'database_tester_authors_roles',
            'conditions' => 'is_executive = 1'
        ],
        'products' => [
            Product::class,
            'table' => 'database_tester_authors_products',
            'key' => 'author_code',
            'parentKey' => 'code',
            'otherKey' => 'product_code',
            'relatedKey' => 'code',
        ],
    ];

    public $morphMany = [
        'event_log' => [
            EventLog::class,
            'name' => 'related',
            'delete' => true,
            'softDelete' => true
        ],
    ];

    public $morphOne = [
        'meta' => [Meta::class, 'name' => 'taggable'],
    ];

    public $morphToMany = [
        'tags' => [
            Tag::class,
            'name'  => 'taggable',
            'table' => 'database_tester_taggables',
            'pivot' => ['added_by']
        ],
    ];
}

class SoftDeleteAuthor extends Author
{
    use \October\Rain\Database\Traits\SoftDelete;
}
