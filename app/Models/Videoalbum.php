<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\ModelTaggableTrait;

/**
 * Class Videoalbum.
 *
 * @author  The scaffold-interface created at 2017-02-18 11:47:16pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Videoalbum extends Model
{
    use EloquentTrait, Sluggable, SluggableScopeHelpers, ModelTaggableTrait;


    protected $table = 'videoalbums';

    /**
     * Videos of this album
     *
     * @return HasMany
     */
    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }

    /**
     * Owner of this album
     *
     * @return HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->first();
    }

    /**
     * A preview of this album
     *
     * @return Video
     */
    public function thumb()
    {
        return $this->hasMany('App\Models\Video')->orderBy('id', 'desc')->first();
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
                'source' => 'name',
                'unique' => true
            ]
        ];
    }

    public function getCover(){
        $video = $this->thumb();
        return url(Video::get_video_thumbnail($video->url));
    }
}
