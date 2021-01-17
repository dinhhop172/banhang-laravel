<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

    public function bills(){
        return $this->hasMany('App\Models\Bills', 'id_customer', 'id');
    }
}
