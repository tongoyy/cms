<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sp3 extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Request'); // Pastikan nama field benar
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'Purchase_Order'); // Pastikan nama field benar
    }

    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID');
    }

    public function purchaseRequestItems()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'Purchase_Requests_ID');
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'Purchase_Orders_ID');
    }
}
