<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'purchase_requests';

    /* Kode Ototmatis */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchaseRequest) {
            // Ambil nomor terakhir dari database
            $lastNumber = self::latest()->value('Number') ?? 0;

            // Tambah 1 dan buat format 5 digit
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

            // Set PR_Code ke format yang benar
            $purchaseRequest->PR_Code = "#PR-{$nextNumber}-" . date('Y');

            // Simpan angka terakhir ke kolom Number
            $purchaseRequest->Number = $lastNumber + 1;
        });
    }

    /* Relasi Items Detail */
    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'Purchase_Requests_ID');
    }
}
