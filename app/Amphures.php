<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amphures extends Model
{
    protected $table = 'amphures';
    protected $primaryKey = 'AMPHUR_ID';
    public $timestamps = false;
}
