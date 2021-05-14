<?php

declare(strict_types=1);

namespace App\Domains\Options\Models;

use App\Domains\Options\Models\Option;
use Database\Factories\OptionTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OptionType extends Model
{
    use HasFactory;

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [ 'name', 'input_type' ];


    /**
     * options to types relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OptionTypeFactory::new();
    }
}
