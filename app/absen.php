<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absen extends Model
{
    protected $fillable = [
        'nama', 'pagi', 'waktupagi', 'siang', 'waktusiang', 'waktusore', 'sore'
    ];

    protected $table = 'absens';

	   const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';

     protected $casts = [
        'nama' => 'string',
        'pagi' => 'string',
        'siang' => 'string',
        'sore' => 'string',
    ];

}
