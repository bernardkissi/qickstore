<?php

declare(strict_types=1);

namespace Domain\Products\Categories;

use Database\Factories\CategoryFactory;
use Domain\Products\Attributes\Attribute;
use Domain\Products\Categories\Scopes\Scopes;
use Domain\Products\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Scopes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','slug', 'order', 'parent_id'];

    /**
     * Subcategory relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     *  Category products relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the deployments for the project.
     */
    public function filters()
    {
        return $this->hasManyThrough(Attribute::class, Product::class);
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
