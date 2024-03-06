<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplateHeader extends Model
{
    use SoftDeletes;
	protected $table = 'email_template_header';

	public $timestamps = true;

	protected $fillable = [
		'title',
		'description',
		'status'
	];	
	protected $dates = ['deleted_at'];
}
