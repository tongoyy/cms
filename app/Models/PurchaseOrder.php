<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'purchase_orders';

    // public function discount($id)
    // {
    //     $product = PurchaseRequestItem::find($id);
    //     $discount = PurchaseOrder::find($id);
    //     if ($discount) {
    //         if ($discount->type == 'amount') {
    //             $finalPrice = max(0, $product->price - $discount->value);
    //         } elseif ($discount->type == 'percent') {
    //             $finalPrice = $product->price * (1 - $discount->value / 100);
    //         }
    //     } else {
    //         $finalPrice = $product->price;
    //     }
    // }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Requests_ID');
    }

    public function purchaseRequestItems()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Requests_ID');
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'Purchase_Orders_ID');
    }

    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID');
    }
}
