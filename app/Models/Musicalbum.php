<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\ModelTaggableTrait;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Nagy\LaravelRating\Traits\Rate\Rateable;
use Rinvex\Categories\Traits\Categorizable;

class Musicalbum extends Model implements AttachableInterface, LikeableContract
{
    use PaperclipTrait, Likeable, Sluggable, SluggableScopeHelpers, ModelTaggableTrait, Rateable, Categorizable;

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
            'variants' => [
                'medium' => [
                    'auto-orient' => [],
                    'resize'      => ['dimensions' => '512x512'],
                ],
                'thumb' => '150x150#',
            ],
            'attributes' => [
                'variants' => true,
            ],
        ]);
        $this->hasAttachedFile('back', [
            'variants' => [
                'medium' => [
                    'auto-orient' => [],
                    'resize'      => ['dimensions' => '512x512'],
                ],
                'thumb' => '150x150#',
            ],
            'attributes' => [
                'variants' => true,
            ],
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

    public function getCover($size){
        $url = $this->front->url($size);
        if(empty($url)) {
            return '';
        }
        return url($this->front->url($size));
    }
    
    /**
     * 
     */
    public function first_track_json(){
        $track = $this->tracks()->first();
        return json_encode([
            'title' => $track->title,
            'artist' => $track->author,
            'src' => $track->file->url(),
            'pic' => $this->getCover('thumb')
        ]);
    }
    
    public function tracks_json(){
        $tracks = $this->tracks()->get();
        $music_list = [];
        foreach($tracks as $track) {
            $music_list[] = [
                'title' => $track->title,
                'artist' => $track->author,
                'src' => $track->file->url(),
                'pic' => $this->getCover('thumb')
            ];
        }
        return json_encode($music_list);
    }
}
