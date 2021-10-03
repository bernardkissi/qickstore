<?php

namespace Domain\Products\Options;

use Database\Factories\OptionFactory;
use Domain\Products\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * Fillable properties of this class
     *
     * @var array
     */
    protected $fillable = ['name', 'option_type_id'];

    /**
     *  Option types relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function types()
    {
        return $this->belongsTo(OptionType::class, 'option_type_id', 'id');
    }

    //is_filterable

    /**
     * Product Options relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OptionFactory::new();
    }
}
