<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function purchaseOrders()
    {
        return $this->belongsTo(PurchaseOrder::class, 'Purchase_Orders_ID');
    }

    public function purchaseOrdersItems()
    {
        return $this->belongsTo(PurchaseOrder::class, 'Purchase_Orders_ID');
    }
}
