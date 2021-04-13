<?php

namespace App\Domains\Labels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;


    /**
     * Fillable attributes of the model
     * 
     * @var array
     */
    protected $fillable = [
        
        'title',
        'description',
        'visibility',
        'schedule_at',
    ];
}
