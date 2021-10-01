<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens, HasRoles;

    protected $fillable = ['username', 'password'];
    protected $guard = 'admin';
    protected $guard_name = 'admin';
    protected $hidden = ['password'];
    protected $casts = ['account_verified_at' => 'datetime'];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function income()
    {
        return $this->hasMany(Transaction::class)->where('type', TransactionType::Income);
    }

    public function expenses()
    {
        return $this->hasMany(Transaction::class)->where('type', TransactionType::Expenses);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function categoriesList()
    {
        $categories = Category::where('user_id', $this->id)->orWhere('user_id', null)->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

        return $categories;
    }
}
