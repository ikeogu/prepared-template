<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'called_user',
        'status',
        'caller_id',
        'country_network',
        'rates',
        'duration',
        'cost_euro',
        'date',
        'user_id'
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
