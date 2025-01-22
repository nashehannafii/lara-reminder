<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarNomor extends Model
{
    use HasFactory;

    protected $table = 'daftar_nomor';
    protected $fillable = ['nohp', 'otp', 'status'];
}
