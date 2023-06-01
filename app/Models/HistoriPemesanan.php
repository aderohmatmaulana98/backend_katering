<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriPemesanan extends Model
{
    use HasFactory;
    protected $table = 'histori_pemesanan';
    protected $fillable = [
        'id_pemesanan',
    ];
}
