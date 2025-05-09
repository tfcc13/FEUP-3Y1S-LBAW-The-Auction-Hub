<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionWinner extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'auction_winner';

    protected $fillable = [
        'auction_id',
        'user_id',
        'rating',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
