<?php

namespace Domain\Products\Collections\Models;

use Domain\Products\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','description', 'image'];

    /**
     *  Product belongs to category relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
