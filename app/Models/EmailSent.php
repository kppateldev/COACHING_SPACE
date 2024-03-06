<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSent extends Model
{
    use HasFactory;

    protected $table = 'email_sent';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];

}
