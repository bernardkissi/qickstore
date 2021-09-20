<?php

namespace Domain\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * model fillable properties
     *
     * @var array
     */
    protected $fillable =
    [
        'sender',
        'recipients',
        'message',
        'status',
        'type',
        'schedule_at',
    ];
}
