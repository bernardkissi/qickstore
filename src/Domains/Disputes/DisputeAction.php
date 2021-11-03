<?php

declare(strict_types=1);

namespace Domain\Disputes;

use Domain\Disputes\Traits\CanAttachFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DisputeAction extends Model implements HasMedia
{
    use
    SoftDeletes,
    CanAttachFiles,
    InteractsWithMedia,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [
        'dispute_id',
        'action',
        'message',
        'has_attachment',
    ];

    /**
     * Database table for this model
     *
     * @var string
     */
    protected $table = 'dispute_actions';

    /**
     * Returns actions associated with a dispute.
     *
     * @return BelongsTo
     */
    public function dispute(): BelongsTo
    {
        return $this->belongsTo(Dispute::class);
    }
}
