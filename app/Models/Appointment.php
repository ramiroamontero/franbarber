<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'finish_time',
        'comments',
        'client_id',
        'user_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
