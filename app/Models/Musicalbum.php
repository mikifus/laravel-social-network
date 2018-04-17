<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Musicalbum extends Model implements StaplerableInterface
{
    use EloquentTrait, Sluggable, SluggableScopeHelpers;

    /**
     * Status values
     *
     * @var string
     */
    static public $STATUS_CREATED = 1;
    static public $STATUS_PUBLISHED = 10;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'musicalbums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'front', 'back', 'zipfile', 'desc', 'author', 'downloadable', 'status'];

    /**
     * The constructor function is required for Stapler
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('front', [
            'styles' => [
                'medium' => '512x512',
                'thumb' => '150x150#'
            ]
        ]);
        $this->hasAttachedFile('back', [
            'styles' => [
                'medium' => '512x512',
                'thumb' => '150x150#'
            ]
        ]);
        $this->hasAttachedFile('zipfile');
        parent::__construct($attributes);
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes() {
        return parent::getAttributes();
    }

    /**
     * Uploader user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Track list
     *
     * @return HasMany
     */
    public function tracks()
    {
        return $this->hasMany('App\Models\MusicalbumTrack');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['author', 'title'],
                'unique' => true
            ]
        ];
    }
}
