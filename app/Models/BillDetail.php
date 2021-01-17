<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = "bill_detail";

    public function product(){
        return $this->belongsTo('App/Models/Product', 'id_product', 'id');
    }

    public function bill(){
        return $this->belongsTo('App\Models\Bills', 'id_bill', 'id');
    }
}
