<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Vendors;

class SP_Tiga extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purhcaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class, 'Purchase_Orders_ID');
    }

    public function purhcaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'Purchase_Orders_ID');
    }

    public function purhcaseRequest()
    {
        return $this->hasMany(PurchaseRequest::class, 'Purchase_Request_ID');
    }

    public function purhcaseRequestItems()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'Purchase_Request_ID');
    }

    public function vendors()
    {
        return $this->hasMany(Vendors::class, 'Vendors_ID');
    }
}
