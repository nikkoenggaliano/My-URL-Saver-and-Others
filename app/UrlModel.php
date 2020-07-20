<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UrlModel extends Model{
	use SoftDeletes;
	protected $table    = "urls";
 
 	protected $fillable = ['uid','name', 'desc', 'url' ,'public'];

 	protected $softDelete = True;
 	protected $dates = ['deleted_at'];


}
