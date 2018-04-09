<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee';
    protected $primaryKey = 'emp_id';
    public $timestamps = false;
}
