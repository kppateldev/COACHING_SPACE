<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Facilities extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'facilities';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function getTitle($id)
    {
        $result = Facilities::where('id',$id)->first();
        if($result){
            return $result->title;
        }
        else{
            return "N/A";
        }
    }
}
