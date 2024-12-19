<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FileController;

class Auction extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $table = 'auction';

  const STATE_ONGOING = 'Ongoing';
  const STATE_RESUMED = 'Resumed';
  const STATE_CANCELED = 'Canceled';

  protected $fillable = [
    'title',
    'description',
    'start_price',
    'current_bid',
    'start_date',
    'end_date',
    'state',
    'owner_id',
    'category_id',

  ];
  /* 
  protected $guarded = [
    'id',
    'owner_id',
    'state',
    'end_date',
    'start_date',
  ]; */

  protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'owner_id');
  }

  public function fetchUser()
  {
    return $this->user()->get();
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

  public function bids()
  {
    return $this->hasMany(Bid::class, 'auction_id')->orderBy('bid_date', 'desc');
  }

  public function images()
  {
    return $this->hasMany(AuctionImage::class, 'auction_id');
  }

  public function primaryImage($default = false)
  {
    return $this->auctionImage($this->images()->first()?->path) ?? 'images/defaults/default-auction.jpg';
  }

  public function getAllImages()
  {
      return FileController::getAuctionImages($this->id);
  }

  public function auctionImage($fileName)
  { 
    $type = 'auction';
    return FileController::getAuctionImage($type, $this->id, $fileName);
  }

/*   public function auctionImage($path) {
    return FileController::getAuctionImage('auction', $this->id, $path);
} */
  // function used to retrieve the results from a full text search
  public function scopeSearch($query, $searchTerm)
  {
    return $query->whereRaw("ts_vectors @@ plainto_tsquery('english', ?)", [$searchTerm]);
  }

  public function followers()
  {
    return $this->hasMany(FollowAuction::class, 'auction_id');
  }

}
