<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'time',
        'guests',
        'special_requests',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'guests' => 'integer'
    ];
}