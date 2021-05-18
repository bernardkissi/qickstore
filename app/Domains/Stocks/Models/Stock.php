<?php

namespace App\Domains\Stocks\Models;

use App\Domains\Skus\Models\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     *  Stock attributes
     *
     * @var array
     */
    protected $fillable = ['quantity', 'limit'];

    /**
     * Product sku relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
