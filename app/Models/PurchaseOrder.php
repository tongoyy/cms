<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* Relasi Order Detail */
    public function PurchaseRequest()
    {
        return $this->hasMany(PurchaseRequest::class, 'purchase_request_id');
    }

    public function Vendors()
    {
        return $this->hasMany(Vendors::class, 'purchase_request_id');
    }
}
