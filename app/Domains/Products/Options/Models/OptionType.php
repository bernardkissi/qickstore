<?php

declare(strict_types=1);

namespace App\Domains\Products\Options\Models;

use App\Domains\Products\Options\Models\Option;
use Database\Factories\OptionTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Domains\Products\Options\Models\OptionType
 *
 * @property int $id
 * @property string $name
 * @property string $input_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Option[] $options
 * @property-read int|null $options_count
 * @method static \Database\Factories\OptionTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType whereInputType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
    public function options(): HasMany
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
