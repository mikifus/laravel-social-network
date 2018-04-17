<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MusicalbumTrack extends Model implements StaplerableInterface, Sortable
{
    use EloquentTrait, Sluggable, SluggableScopeHelpers, SortableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'musicalbums_tracks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'file', 'description', 'author', 'beatmaker', 'feat', 'downloadable', 'position'];


    /**
     * Sortable config.
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];

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
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Uploader user
     *
     * @return BelongsTo
     */
    public function musicalbum()
    {
        return $this->belongsTo('App\Models\Musicalbum');
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
                'source' => ['musicalbum.author', 'musicalbum.title'],
                'unique' => false
            ]
        ];
    }

    public function getDurationAttribute() {
        $path = $this->file->path();
        if( empty($path) )
        {
            return '0:00';
        }
        if (isset($audio['error'])) {
            return 'error';
        }
        $id3 = new \getID3;
        $audio = $id3
//            ->setOptionMD5Data(true)
//            ->setOptionMD5DataSource(true)
//            ->setEncoding('UTF-8')
            ->analyze($path);

        if( isset($audio['error']) ) {
            return "[File error]";
        }

        $total_seconds = intval($audio['playtime_seconds']);
        $minutes = floor($total_seconds / 60);
        $seconds = $total_seconds % 60;
        return sprintf('%02d:%02d',$minutes, $seconds);
    }
}
