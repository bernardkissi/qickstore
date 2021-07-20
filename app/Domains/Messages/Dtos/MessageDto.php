<?php

namespace App\Domains\Messages\Dtos;

use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\CAST_PRIMITIVES;

/**
 * The data transfer object for the Message model.
 *
 * @property int $id
 * @property string $message
 * @property array $recipients
 * @property array $recipient
 * @property string $sender
 * @property string $state
 * @property string $type
 * @property string $audio_file
 * @property bool $sandbox
 * @property bool $is_schedule
 * @property datetime|null schedule_date
 * @property string $voice_file
 */
class MessageDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES | CAST_PRIMITIVES;
}
