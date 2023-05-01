<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertSymbol extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'symbol_id',
        'user_id',
    ];
}
