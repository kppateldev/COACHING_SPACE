<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strengths extends Model
{
    use HasFactory;

    protected $table = 'strengths';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
