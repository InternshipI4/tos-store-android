<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';
    public $timestamps = true;

    public function store(){
        return $this->belongsTo('App\Stores', 'store_id');
    }

    public function itemPrices(){
        return $this->hasMany('App\ItemPrice', 'item_id');
    }

    public function itemOptions(){
        return $this->hasMany('App\ItemOptions', 'item_id');
    }

    public function itemAddOns(){
        return $this->hasMany('App\ItemAddOn', 'item_id');
    }
}
