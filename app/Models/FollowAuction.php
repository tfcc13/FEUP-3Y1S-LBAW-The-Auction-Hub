<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowAuction extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'follows_auction';
    protected $primaryKey = null;
    public $incrementing = false;

    // Relationship to Auction
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}
