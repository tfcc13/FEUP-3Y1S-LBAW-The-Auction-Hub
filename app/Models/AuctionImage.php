<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{
    use HasFactory;

  public $timestamps = false;
  protected $table = 'auction_image';
  protected $fillable = [
    'path', 'auction_id'
  ];
  
  public function auction(){
    return $this->belongsTo(Auction::class, 'auction_id');
  }
}
