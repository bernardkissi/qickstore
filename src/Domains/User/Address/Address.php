<?php

namespace Domain\User\Address;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use
    HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_address',
        'city',
        'state',
        'country',
        'digital address',
        'firstname',
        'lastname',
        'email',
        'phone'
    ];

    /**
    * Address belongs to a user/visitor.
    *
    * @return MorphTo
    */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = false;

    /**
    * Create a new factory instance for the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    protected static function newFactory()
    {
        return AddressFactory::new();
    }
}
