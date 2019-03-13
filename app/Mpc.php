<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mpc extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'ktp', 'name', 'birth_date', 'gender', 'address', 'phone', 'branch_id', 'user_id', 'active',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function cso()
    {
        return $this->belongsTo('App\Cso');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
