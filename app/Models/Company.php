<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the wallet associated with the company.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
}
