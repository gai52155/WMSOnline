<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_detail';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
}
