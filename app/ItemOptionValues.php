<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOptionValues extends Model
{
    protected $table = 'item_option_values';
    public $timestamps = true;

    function itemOption(){
        return $this->belongsTo('App\ItemOption', 'option_id');
    }
}
