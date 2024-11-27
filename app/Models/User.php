<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'birth_date',
        'rating',
        'description' 
    ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'password' => 'hashed',
  ];

  public function followsAuction()
  {
    return $this->belongsToMany(Auction::class, 'follows', 'user_id', 'auction_id');
  } 


  public function ownAuction()
  {
    return $this->hasMany(Auction::class, 'owner_id')->orderBy('state','asc');
  }

  public function userImage()
  {
    return $this->hasOne(UserImage::class);  // Use hasMany() if a user can have multiple images
  }

  public function ownsBids()
  {
      return $this->hasMany(Bid::class, 'user_id')->orderBy('time', 'desc');
  }
}
