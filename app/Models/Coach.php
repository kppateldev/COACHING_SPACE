<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CoachingLevel;
use App\Models\Strengths;

class Coach extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'coaches';
    protected $guarded = ['id'];
    protected $casts = [
        'coaching_level' => 'array',
        'strengths' => 'array',
    ];

    public function coachCoachingLevel()
    {
        return $this->belongsTo('App\Models\CoachingLevel', 'id', 'coaching_level');
    }

    public function coachCoachingLevelStr($field = '')
    {
        $coaching_level = $this->coaching_level;
        if(isset($coaching_level))
        {
            if(!is_array($coaching_level))
            {
                $coaching_level = explode(',',$coaching_level);
            }
            $areas = CoachingLevel::whereIn('id',$coaching_level)->select('title')->get();
            $arr = array();
            $str ="";
            if ($areas->count()) {
                $areas = $areas;
                foreach ($areas as $area1) {
                    $str = $area1['title'];
                    array_push($arr,$str);
                }
                $str = implode(", ", $arr);
            }
            return $str;
        }
        return '---';
    }

    public function coachStrengths()
    {
        return $this->belongsTo('App\Models\Strengths', 'id', 'strengths');
    }

    public function coachStrengthsStr($field = '')
    {
        $strengths = $this->strengths;
        if(isset($strengths))
        {
            if(!is_array($strengths))
            {
                $strengths = explode(',',$strengths);
            }
            $areas = Strengths::whereIn('id',$strengths)->select('title')->get();
            $arr = array();
            $str ="";
            if ($areas->count()) {
                $areas = $areas;
                foreach ($areas as $area1) {
                    $str = $area1['title'];
                    array_push($arr,$str);
                }
                $str = implode(", ", $arr);
            }
            return $str;
        }
        return '---';
    }

    public function availability()
    {
        return $this->hasMany('App\Models\AvailabilityDate','coach_id','id');
    }

    public function unavailability()
    {
        return $this->hasMany('App\Models\UnAvailabilityDate','coach_id','id');
    }

}
