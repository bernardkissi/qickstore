<?php

declare(strict_types=1);

namespace App\Domains\Categories\Models;

use App\Domains\Categories\Scopes\Scopes;
use App\Domains\Products\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Scopes;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','slug', 'order'];


    /**
     * Subcategory relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    /**
     *  Category products relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')
            ->withTimestamps();
    }

    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
