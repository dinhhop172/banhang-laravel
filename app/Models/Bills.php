<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $table = "bills";

    public function customer(){
        return $this->belongsTo('App/Models/Customer', 'id_customer', 'id');
    }

    public function bill_detail(){
        return $this->hasMany('App\Models\BillDetail', 'id_bill', 'id');
    }
}
