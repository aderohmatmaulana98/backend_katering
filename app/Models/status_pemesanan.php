<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_pemesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_status'
    ];
}
