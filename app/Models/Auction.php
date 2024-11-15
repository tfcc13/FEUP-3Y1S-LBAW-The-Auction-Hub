<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'start_price',
        'category_id',
    ];

    protected $guarded = [
        'id',
        'owner_id',
        'state',
        'end_date',
        'start_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryName()
    {
        return $this->category->name ?? null;
    }
}
