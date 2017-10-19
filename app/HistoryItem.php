<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryItem extends Model
{
    protected $table = 'history_items';
    public $timestamps = true;

    function history(){
        return $this->belongsTo('App\History', 'history_id');
    }

    function historyItemOption(){
        return $this->hasMany('App\HistoryItemOption');
    }

    function  historyItemAddOn(){
        return $this->hasMany('App\HistoryItemAddOn');
    }
}
