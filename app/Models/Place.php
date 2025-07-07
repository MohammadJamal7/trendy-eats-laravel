<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Place extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'website',
        'image',
        'latitude',
        'longitude',
        'cuisine_type',
        'rating',
        'price_range',
        'opening_hours',
        'is_active',
        'country_id',
        'category_id',
        'category_name',
        'gallery' => 'array',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'opening_hours' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url', 'is_favorite'];

    /**
     * Get the country that owns the place.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('images/' . $this->image);
        }
        return null;
    }

    /**
     * Get the category name
     */
    public function getCategoryNameAttribute($value)
    {
        // If category_name is set, return it
        if ($value) {
            return $value;
        }
        
        // Otherwise, get it from the relationship
        if ($this->category) {
            return $this->category->name;
        }
        
        return null;
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getIsFavoriteAttribute()
    {
        $user = Auth::user();
        if (!$user) return false;
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }
} 