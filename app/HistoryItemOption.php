<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryItemOption extends Model
{
    protected $table = 'history_item_options';
    public $timestamps = true;

    function historyItem(){
        return $this->belongsTo('App\HistoryItem', 'history_item_id');
    }
}
