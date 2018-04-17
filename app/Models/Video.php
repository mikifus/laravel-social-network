<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MediaEmbed\MediaEmbed;

class Video extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url'];

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
     * Album
     *
     * @return BelongsTo
     */
    public function videoalbum()
    {
        return $this->belongsTo('App\Models\Videoalbum');
    }

    /**
     * Get the video media object
     *
     * @param string $value
     * @return MediaEmbed\MediaEmbed\MediaObject
     */
    public function getMediaObjectAttribute( $value )
    {
        $MediaEmbed = new MediaEmbed();
        $MediaObject = $MediaEmbed->parseUrl( $this->attributes['url'] );
        $MediaObject->setAttribute([
            'class' => 'embed-responsive-item'
        ]);
        $MediaObject->setParam([
            'autoplay' => 0,
            'loop' => 1
        ]);
        $MediaObject->setAttribute([
//            'type' => null,
//            'class' => 'iframe-class',
//            'width' => "100",
//            'height' => "75",
            'data-html5-parameter' => true
        ]);
        return $MediaObject;
    }
}
