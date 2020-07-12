<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlModel extends Model
{
	protected $table    = "urls";
 
 	protected $fillable = ['uid','name', 'desc', 'url' ,'public'];


    //
}
