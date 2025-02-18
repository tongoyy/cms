<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendors()
    {
        return $this->belongsTo(Vendors::class, 'Vendors_ID');
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'Purchase_Request_ID');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'Purchase_Orders_ID');
    }

    /* Kode Ototmatis */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vendors) {
            // Ambil nomor terakhir dari database
            $lastNumber = self::latest()->value('Number') ?? 0;

            // Tambah 1 dan buat format 5 digit
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            // Set PR_Code ke format yang benar
            $vendors->VendorCode = "VC-{$nextNumber}";

            // Simpan angka terakhir ke kolom Number
            $vendors->Number = $lastNumber + 1;
        });
    }
}
