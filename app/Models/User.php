<?php

namespace App\Models;

use App\Models\Auction;
use App\Models\MoneyManager;
use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

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
        'description',
        'birth_date',
        'credit_balance',
        'is_admin'
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

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function fetchNotifications()
    {
        return $this->notifications()->get();
    }

    public function ownAuctions()
    {
        return $this->hasMany(Auction::class, 'owner_id');
    }

    public function userImage()
    {
        return $this->hasOne(UserImage::class);  // Use hasMany() if a user can have multiple images
    }
    public function userFileImage($fileName)
    { 
      $type = 'auction';
      return FileController::getUserImage($fileName);
    }
    public function ownsBids()
    {
        return $this->hasMany(Bid::class, 'user_id');
    }
    
    public function transactions()
    {
        return $this->hasMany(MoneyManager::class, 'user_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(MoneyManager::class, 'recipient_user_id');
    }

    public function allTransactions()
    {
        return MoneyManager::where('user_id', $this->id)
            ->orWhere('recipient_user_id', $this->id);
    }
    public function activeBids()
    {
        return $this
            ->ownsBids()
            ->whereHas('auction', function ($query) {
                $query->where('state', 'Ongoing');
            })
            ->count() > 0;
    }

    public function auctionWon()
    {
        return $this
            ->hasManyThrough(Auction::class, AuctionWinner::class, 'user_id', 'id', 'id', 'auction_id')
            ->orderBy('auction_id');
    }

    public function addMoney(float $amount): void
    {
        // Ensure the amount is positive
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero.');
        }

        // Increment the user's balance
        $this->increment('credit_balance', $amount);
    }

    public function scopeSearch($query, $searchTerm)
    {
        $query->whereRaw("to_tsvector('english', name) @@ plainto_tsquery(?)", [$searchTerm]);
        $query->where('is_admin', '!=', true);

        return $query;
    }

    public function followsAuction()
    {
        return $this->belongsToMany(Auction::class, 'follows_auction', 'user_id', 'auction_id');
    }
}
