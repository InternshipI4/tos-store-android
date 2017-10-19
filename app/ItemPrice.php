<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    protected $table = 'item_prices';
    public $timestamps = true;

    public function item(){
        return $this->belongsTo('App\Items', 'item_id');
    }
}
