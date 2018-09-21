<?php namespace App\Traits;

use Cviebrock\EloquentTaggable\Taggable;
use Cviebrock\EloquentTaggable\Models\Tag;


/**
 * Class Taggable
 *
 * @package Cviebrock\EloquentTaggable
 */
trait ModelTaggableTrait
{
    use Taggable;
    /**
     * Get a collection of all tags the model has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public static function searchModelTags($term)
    {
        $term = trim($term);
        return Tag::join('taggable_taggables','taggable_taggables.tag_id','=','taggable_tags.tag_id')->where('taggable_type','=',static::class)->where('name', 'like', "%".$term."%")->offset(0)->limit(10)->pluck('name')->toArray();
    }
}
