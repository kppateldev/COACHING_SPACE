<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Pages extends Model
{
    use HasFactory;

    use Sluggable;

    protected $table = 'pages';
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

    protected $casts = [
		'page_meta' => 'array'
	];

    public static function getAllPages()
    {
        return Pages::select('slug','title')->where('status',1)->get();
    }

}
