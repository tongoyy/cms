<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPettyCash extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PettyCash()
    {
        return $this->belongsTo(PettyCash::class, 'Petty_Cash_ID');
    }

    public function LaporanPettyCash()
    {
        return $this->belongsTo(LaporanPettyCash::class, 'Petty_Cash_ID');
    }
}
