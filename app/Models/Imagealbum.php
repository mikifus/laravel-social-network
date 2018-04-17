<?php

namespace App\Models;

use Codesleeve\Stapler\ORM\EloquentTrait;
use Illuminate\Database\Eloquent\Model;
//use Conner\Likeable\LikeableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Imagealbum extends Model
{
    use EloquentTrait, Sluggable, SluggableScopeHelpers;

    protected $table = 'imagealbums';

    /**
     * Videos of this album
     *
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    /**
     * A preview of this album
     *
     * @return Image
     */
    public function thumb()
    {
        return $this->hasMany('App\Models\Image')->orderBy('id', 'desc')->first();
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
                'source' => 'title',
                'unique' => true
            ]
        ];
    }
}
