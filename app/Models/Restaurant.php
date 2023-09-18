<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'open_from' => 'datetime',
        'open_to' => 'datetime',
    ];

    public function getOpenFromTime(){
        $hours = $this->open_from->format('H');
        $minutes = $this->open_from->format('i');
        return [$hours, $minutes];
    }

    public function getOpenToTime(){
        $hours = $this->open_to->format('H');
        $minutes = $this->open_to->format('i');
        return [$hours, $minutes];
    }

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
}
