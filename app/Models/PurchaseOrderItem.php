<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'Purchase_Orders_ID');
    }
}
