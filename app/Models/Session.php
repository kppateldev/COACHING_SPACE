<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sessions';
    protected $guarded = ['id'];

    public function UserData(){
        return $this->hasOne('App\Models\User','id','user_id')->withTrashed();
    }

    public function CoachData(){
        return $this->hasOne('App\Models\Coach','id','coach_id')->withTrashed();
    }

    public function ReviewData(){
        return $this->hasOne('App\Models\Review','session_id','id');
    }    

}
