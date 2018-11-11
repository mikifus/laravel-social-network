<?php

namespace App\Models;

// use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\ModelTaggableTrait;
use Nagy\LaravelRating\Traits\Rate\Rateable;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;

class Imagealbum extends Model implements LikeableContract
{
    use /*PaperclipTrait, */Sluggable, SluggableScopeHelpers, ModelTaggableTrait, Likeable, Rateable;

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
     * owner of this album
     *
     * @return Image
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->first();
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

    /**
     * Get thumbnail
     *
     * @return BelongsTo
     */
    public function getCover()
    {
        return $this->thumb()->file->url('medium');
    }
}
