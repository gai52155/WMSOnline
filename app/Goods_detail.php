<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods_detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goods_detail';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
}
