<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryItemAddOn extends Model
{
    protected $table = 'history_item_add_ons';
    public $timestamps = true;

    function historyItem(){
        return $this->belongsTo('App\HistoryItem', 'history_item_id');
    }
}
