<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'address';

    protected $fillable = [
        'street',
        'city',
        'district',
        'zip_code',
        'country',
    ];

    protected $guarded = [ 
    'id',
    'user:id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
