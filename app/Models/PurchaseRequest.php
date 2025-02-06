<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'purchase_requests';

    /* Relasi Items Detail */
    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'Purchase_Request_ID');
    }

    public function kodeOtomatis()
    {
        return '#PR-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
