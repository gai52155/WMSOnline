<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distincts extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'DISTRICT_ID';
    public $timestamps = false;
}
