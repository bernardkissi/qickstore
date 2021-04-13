<?php

namespace App\Domains\Categories\Models;

use Database\Factories\SubCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','slug', 'order'];


    /**
     * Category relationship
     *
     * @return belongsTo
     */
    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Children relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(SubCategory::class, 'parent_id', 'id');
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SubCategoryFactory::new();
    }
}
