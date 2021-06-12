<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title'
    ];

    public function pesanan()
    {
        return $this->hasOne(Pesanan::class, 'kurir_id', 'id');
    }
}
