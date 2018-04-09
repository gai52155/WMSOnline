<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warehouse_detail';
    protected $primaryKey = 'warehouse_detail_id';
    public $timestamps = false;
}
