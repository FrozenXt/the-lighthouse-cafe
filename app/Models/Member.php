<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'membership_tier',
        'join_date',
        'points'
    ];

    protected $casts = [
        'join_date' => 'date',
        'points' => 'integer'
    ];

    public function getDiscountPercentage()
    {
        return match($this->membership_tier) {
            'bronze' => 5,
            'silver' => 10,
            'gold' => 15,
            'platinum' => 20,
            default => 0
        };
    }
}
