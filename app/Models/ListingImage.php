<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ListingImage
 *
 * @property-read string $src
 * @property-read \App\Models\Listing|null $listing
 * @method static \Illuminate\Database\Eloquent\Builder|ListingImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListingImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListingImage query()
 * @mixin \Eloquent
 */
class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['src'];

    /**
     * Listing relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the real path to src.
     *
     * @return string
     */
    public function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }
}
