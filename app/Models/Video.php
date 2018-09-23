<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MediaEmbed\MediaEmbed;
// use Cviebrock\EloquentTaggable\Taggable;
use App\Traits\ModelTaggableTrait;

class Video extends Model
{
    use ModelTaggableTrait;
    
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
    public function getMediaObjectAttribute()
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
    /**
    * Retrieves the thumbnail from a youtube or vimeo video
    * @param - $src: the url of the "player"
    * @return - string
    * @todo - do some real world testing. 
    * 
    * Source: https://gist.github.com/secretstache/3f55b4bc2ac7d23c516f
    * 
    **/
    static function get_video_thumbnail( $src ) {

        $url_pieces = explode('/', $src);
        
        if ( $url_pieces[2] == 'player.vimeo.com' ) { // If Vimeo

            $id = $url_pieces[4];
            $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
            $thumbnail = $hash[0]['thumbnail_large'];

        } elseif ( $url_pieces[2] == 'www.youtube.com' ) { // If Youtube

            if(isset($url_pieces[4])){
                $extract_id = explode('?', $url_pieces[4]);
                $id = $extract_id[0];
            } else {
                $extract_id = explode('=', $url_pieces[3]);
                $id = $extract_id[1];
            }
            $thumbnail = 'http://img.youtube.com/vi/' . $id . '/mqdefault.jpg';

        }

        return $thumbnail;

    }

    public function getCover(){
        return $this->get_video_thumbnail($this->url);
    }
}
