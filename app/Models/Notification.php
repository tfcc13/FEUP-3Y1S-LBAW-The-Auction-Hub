<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'notification';

  protected $fillable = [//ask if admin can alter notifications
    'content',
    'notification_date',
    'type',
    'view_status',
    'user_id',
    'bid_id',
    'report_user_id',
    'auction_id',
  ];

  // protected $guarded = [
  //   'content',
  //   'notification_date',
  //   'type',
  //   'view_status',
  //   'user_id',
  //   'bid_id',
  //   'report_user_id',
  //   'auction_id',
  // ];

  // Relationships

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function bid()
  {
    return $this->belongsTo(Bid::class);
  }

  public function auction()
  {
    return $this->belongsTo(Auction::class);
  }
}
