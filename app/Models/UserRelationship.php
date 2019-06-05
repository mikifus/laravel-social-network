<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model
{

    protected $table = 'user_relationship';

    public $timestamps = false;


    public function relative(){
        return $this->belongsTo('App\Models\User', 'related_user_id');
    }

    public function main(){
        return $this->belongsTo('App\Models\User', 'main_user_id');
    }

    public function getAllow(){
        return $this->allow;
    }

    public function getType(){
        return self::getTypeString($this->relation_type);
    }
    
    public static function getTypeString($type){
        if ($type == 0){
            return trans('relationships.type.fan');
        }else if($type == 1){
            return trans('relationships.type.collaborator');
        }else if($type == 2){
            return trans('relationships.type.dj');
        }else if($type == 3){
            return trans('relationships.type.producer');
        }else if($type == 4){
            return trans('relationships.type.manager');
        }else{
            return trans('relationships.type.mate');
        }
    }
}
