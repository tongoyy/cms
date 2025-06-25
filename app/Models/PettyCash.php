<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;
    protected $guarded = [];

    /* Relasi Laporan Petty Cash */
    public function LaporanPettyCash()
    {
        return $this->hasMany(LaporanPettyCash::class, 'Petty_Cash_ID');
    }
}
