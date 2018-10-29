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

class Image extends Model implements AttachableInterface,LikeableContract
{
    use PaperclipTrait, Sluggable, SluggableScopeHelpers, ModelTaggableTrait, Likeable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'file'];

    /**
     * The constructor function is required for Stapler
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('file', [
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

        parent::__construct($attributes);
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
        return $this->file->url('medium');
    }
}
