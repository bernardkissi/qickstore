<?php

namespace App\Domains\Delivery\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    /**
    * Fillable properties of the model.
    *
    * @var array
    */
    protected $fillable = [

        'service',
        'amount',
        'status',
        'delivery_info',
        'delivery_code',
        'client_code',
        'estimate_id',
        'instructions',
        'download_link',
        'error',
        'completed_at',
        'failed_at'
    ];
}
