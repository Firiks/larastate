<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Listing
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Listing newModelQuery()
 * @method static Builder|Listing newQuery()
 * @method static Builder|Listing query()
 * @method static Builder|Listing whereCreatedAt($value)
 * @method static Builder|Listing whereId($value)
 * @method static Builder|Listing whereUpdatedAt($value)
 * @property int $beds
 * @property int $baths
 * @property int $area
 * @property string $city
 * @property string $code
 * @property string $street
 * @property string $street_nr
 * @property int $price
 * @method static \Database\Factories\ListingFactory factory($count = null, $state = [])
 * @method static Builder|Listing whereArea($value)
 * @method static Builder|Listing whereBaths($value)
 * @method static Builder|Listing whereBeds($value)
 * @method static Builder|Listing whereCity($value)
 * @method static Builder|Listing whereCode($value)
 * @method static Builder|Listing wherePrice($value)
 * @method static Builder|Listing whereStreet($value)
 * @method static Builder|Listing whereStreetNr($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ListingImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\User|null $owner
 * @method static Builder|Listing filter(array $filters)
 * @method static Builder|Listing mostRecent()
 * @method static Builder|Listing withoutSold()
 * @mixin \Eloquent
 */
class Listing extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'
    ];

    /**
     * Sortable attributes.
     *
     * @var array
     */
    protected $sortable = [
        'price', 'created_at'
    ];

    /**
     * Owner relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'by_user_id'
        );
    }

    /**
     * Images relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    /**
     * Offers relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'listing_id');
    }

    /**
     * Scope for most recent listings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Scope listings that are not sold.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutSold(Builder $query): Builder
    {
        return $query->whereNull('sold_at');
    }

    /**
     * Scope custom filter.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['priceFrom'] ?? false,
            fn ($query, $value) => $query->where('price', '>=', $value)
        )->when(
            $filters['priceTo'] ?? false,
            fn ($query, $value) => $query->where('price', '<=', $value)
        )->when(
            $filters['beds'] ?? false,
            fn ($query, $value) => $query->where('beds', (int)$value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['baths'] ?? false,
            fn ($query, $value) => $query->where('baths', (int)$value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['areaFrom'] ?? false,
            fn ($query, $value) => $query->where('area', '>=', $value)
        )->when(
            $filters['areaTo'] ?? false,
            fn ($query, $value) => $query->where('area', '<=', $value)
        )->when(
            $filters['deleted'] ?? false,
            fn ($query, $value) => $query->withTrashed()
        )->when(
            $filters['by'] ?? false,
            fn ($query, $value) =>
            !in_array($value, $this->sortable)
                ? $query :
                $query->orderBy($value, $filters['order'] ?? 'desc')
        );
    }

}
