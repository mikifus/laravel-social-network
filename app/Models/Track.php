<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\ModelTaggableTrait;
use Nagy\LaravelRating\Traits\Rate\Rateable;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Rinvex\Categories\Traits\Categorizable;

class Track extends Model implements AttachableInterface, LikeableContract
{
    use PaperclipTrait, Sluggable, SluggableScopeHelpers, ModelTaggableTrait, Likeable, Rateable, Categorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tracks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'file', 'description', 'author', 'beatmaker', 'feat', 'downloadable'];

    /**
     * The constructor function is required for Stapler
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('file');
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
        return $this->belongsTo('App\User');
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

    /**
     * Track json for player
     *
     * @return BelongsTo
     */
    public function track_json()
    {
        return json_encode([
            'title' => $this->title,
            'artist' => $this->author,
            'src' => $this->file->url()
        ]);
    }
}
