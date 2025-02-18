<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sp3 extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* Kode Ototmatis */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sp3) {
            // Ambil nomor terakhir dari database
            $lastNumber = self::latest()->value('Number') ?? 0;

            // Tambah 1 dan buat format 5 digit
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

            // Set PR_Code ke format yang benar
            $sp3->SP3_Number = "{$nextNumber}-AMI-SP3/" . date('M/Y');

            // Simpan angka terakhir ke kolom Number
            $sp3->Number = $lastNumber + 1;
        });
    }

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
