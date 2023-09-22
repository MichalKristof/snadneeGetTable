<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'time_from' => TimeCast::class,
        'time_to' => TimeCast::class,
    ];

    public function getTimeFrom(){
        $hours = $this->time_from->format('H');
        $minutes = $this->time_from->format('i');
        return [$hours, $minutes];
    }

    public function user() : belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table() : belongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function restaurant() : belongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
