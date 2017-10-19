<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemAddOn extends Model
{
    protected $table = 'item_add_ons';
    public $timestamps = true;

    function items(){
        return $this->belongsTo('App\Items', 'item_id');
    }
}
