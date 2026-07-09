<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'cv_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
