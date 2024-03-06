<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCodeAdmin extends Model
{
    use HasFactory;

    protected $table = 'verification_code_admin';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];

}
