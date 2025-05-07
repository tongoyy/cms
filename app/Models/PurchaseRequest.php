<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseRequestItem;
use App\Models\Vendors;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'purchase_requests';

    /* Relasi Items Detail */
    public function purchaseRequestItems()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'Purchase_Requests_ID');
    }

    /* Relasi Vendors */
    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID'); // Ensure the foreign key matches the database column
    }
}
