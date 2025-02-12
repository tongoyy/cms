<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Requests_ID');
    }

    public function purchaseRequestItems()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Requests_ID');
    }
}
