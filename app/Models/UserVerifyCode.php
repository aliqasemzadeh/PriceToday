<?php

namespace App\Models;

use ALajusticia\Expirable\Traits\Expirable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVerifyCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    Use Expirable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'verification_code', 'verify_ip_address', 'status'
    ];
}
