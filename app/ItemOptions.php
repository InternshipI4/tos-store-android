<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOptions extends Model
{
    protected $table = 'item_options';
    public $timestamps = true;

    function itemOptionValue(){
        return $this->hasMany('App\ItemOptionValue');
    }

    function items(){
        return $this->belongsTo('App\Items', 'item_id');
    }
}
