<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID');
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Request_ID');
    }
}
