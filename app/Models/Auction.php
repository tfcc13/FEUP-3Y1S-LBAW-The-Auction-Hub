<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $table = 'auction';

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

  protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
];

  public function user()
  {
    return $this->belongsTo(User::class, 'owner_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function categoryName()
  {
    return $this->category->name ?? null;
  }

  public function auctionWinner()
  {
    return $this->hasOne(AuctionWinner::class, 'auction_id');
  }

  public function bids(){
    return $this->hasMany(Bid::class, 'auction_id')->orderBy('bid_date','desc');
  }

  public function images() {
    return $this->hasMany(AuctionImage::class, 'auction_id');
  }


  public function primaryImage()
  {
      return $this->images()->first()->path ?? 'images/defaults/default-auction.jpg';
  }
  // function used to retrieve the results from a full text search
  public function scopeSearch($query, $searchTerm)
  {
    // This function will apply the full-text search query to the database
    return $query->whereRaw("ts_vectors @@ plainto_tsquery('english', ?)", [$searchTerm]);
  }
}
