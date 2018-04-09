<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_detail';
    protected $primaryKey = 'order_detail_id';
    public $timestamps = false;
}
