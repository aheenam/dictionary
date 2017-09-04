<?php

namespace Aheenam\Dictionary\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{

	protected $fillable = ['key', 'language'];

}