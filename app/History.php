<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    public $timestamps = true;

    function historyItem(){
        return $this->hasMany('App\HistoryItem');
    }

    function stores(){
        return $this->belongsTo('App\Stores','store_id');
    }
}
