<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['first_name', 'last_name', 'gender', 'title',
                        'country', 'description', 'birthday', 'hourly_rate'
                    ];

    protected $casts = [
        'birthday' => 'datetime',
        'hourly_rate' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
