<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Restaurant extends Model
{
    use HasFactory, hasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'capacity',
        'open_from',
        'open_to',
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
        'open_from' => TimeCast::class,
        'open_to' => TimeCast::class,
    ];

    public function getSlugOptions(): SlugOptions
    {
        return (new SlugOptions())
            ->generateSlugsFrom("name")
            ->saveSlugsTo("slug")
            ->usingSeparator("-")
            ->slugsShouldBeNoLongerThan(255);
    }

    public function tables() : hasMany
    {
        return $this->hasMany(Table::class);
    }

    public function reservations() : hasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
