<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingLevel extends Model
{
    use HasFactory;

    protected $table = 'coaching_levels';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
