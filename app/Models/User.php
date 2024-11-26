<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; used to send an email verification to the user
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable  // implements MustVerifyEmail
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
}
