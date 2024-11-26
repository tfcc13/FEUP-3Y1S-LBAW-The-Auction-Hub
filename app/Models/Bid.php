<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $table = 'bid';
  protected $fillable = [
    'user_id',
    'auction_id',
    'amount',
    'bid_date' 
  ];
  protected $casts = [
    'bid_date' => 'datetime',
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
