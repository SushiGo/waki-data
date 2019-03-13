<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryUndangan extends Model
{
    protected $fillable = [
        'date', 'bank_id', 'branch_id', 'type_cust_id', 'data_undangan_id', 'active', 
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function cso()
    {
        return $this->belongsTo('App\Cso');
    }

    public function type_cust()
    {
        return $this->belongsTo('App\TypeCust');
    }

    public function data_undangan()
    {
        return $this->belongsTo('App\DataUndangan');
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
