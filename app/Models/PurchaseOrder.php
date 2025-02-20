<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'purchase_orders';

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'Purchase_Orders_ID');
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Requests_ID');
    }

    public function purchaseRequestItems()
    {
        return $this->hasMany(PurchaseRequest::class, 'Purchase_Requests_ID');
    }

    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID');
    }
}
