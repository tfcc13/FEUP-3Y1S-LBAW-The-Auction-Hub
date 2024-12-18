<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyManager extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'money_manager';

    protected $fillable = [
        'reference',
        'amount',
        'type',
        'recipient_user_id',
        'state',
        'user_id',
        'operation_date',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipientUser()
    {
        return $this->belongsTo(User::class);
    }

    public function isDeposit()
    {
        return $this->type === 'Deposit';
    }

    public function isWithdraw()
    {
        return $this->type === 'Withdraw';
    }

    public function isTransaction()
    {
        return $this->type === 'Transaction';
    }
}
