<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'table_id',
        'time_from',
        'time_to',
        'date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time_from' => 'datetime',
        'time_to' => 'datetime',
    ];

    public function getTimeFrom(){
        $hours = $this->time_from->format('H');
        $minutes = $this->time_from->format('i');
        return [$hours, $minutes];
    }
}
