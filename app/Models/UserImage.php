<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user_image';

    protected $fillable = [
        'path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
