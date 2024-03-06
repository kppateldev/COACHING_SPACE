<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;
	protected $table = 'email_template';

	public $timestamps = true;

	protected $fillable = [
		'header_id',
		'footer_id',
		'title',
		'subject',
		'body',
		'status'
	];
	protected $dates = ['deleted_at'];

	public function hasTemplateHeader() {
		return $this->hasOne('App\Models\EmailTemplateHeader','id','header_id');
	}

	public function hasTemplateFooter() {
		return $this->hasOne('App\Models\EmailTemplateFooter','id','footer_id');
	}
}
