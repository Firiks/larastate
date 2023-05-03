<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Offer
 *
 * @property-read \App\Models\User|null $bidder
 * @property-read \App\Models\Listing|null $listing
 * @method static Builder|Offer byMe()
 * @method static Builder|Offer except(\App\Models\Offer $offer)
 * @method static Builder|Offer newModelQuery()
 * @method static Builder|Offer newQuery()
 * @method static Builder|Offer query()
 * @mixin \Eloquent
 */
class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    /**
     * Listing relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    /**
     * Bidder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }

    /**
     * Scope a query to only include offers made by the current user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMe(Builder $query): Builder
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }

    /**
     * Scope a query to exclude the given offer.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Offer $offer
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcept(Builder $query, Offer $offer): Builder
    {
        return $query->where('id', '!=', $offer->id);
    }
}
