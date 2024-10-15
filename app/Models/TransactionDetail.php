<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'transaction_category_id', 'name', 'value_idr'];

    public function category()
    {
        return $this->belongsTo(MsCategory::class, 'transaction_category_id');
    }

    public function transaction()
    {
        return $this->belongsTo(TransactionHeader::class, 'transaction_id');
    }
}
