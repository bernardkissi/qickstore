<?php

declare(strict_types=1);

namespace Domain\Disputes;

use App\Traits\HasTimeline;
use Domain\Disputes\DisputeAction;
use Domain\Disputes\States\DisputeState;
use Domain\Disputes\Traits\CanAttachFiles;
use Domain\Disputes\Traits\CanTransitionDispute;
use Domain\Refunds\Refund;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

class Dispute extends Model implements HasMedia
{
    use
    SoftDeletes,
    InteractsWithMedia,
    CanAttachFiles,
    HasTimeline,
    HasStates,
    CanTransitionDispute,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'disputable_reference_id',
        'disputable_transcation_reference',
        'subject',
        'customer_dispute',
        'merchant_response',
        'has_attachment',
        'customer_mobile',
        'customer_email',
        'state',
        'history'
    ];

    /**
    * Database table for this model
    *
    * @var string
    */
    protected $table = 'disputes';

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'state' => DisputeState::class,
    ];

    /**
     * Get the order that owns the order dispute.
     *
     * @return MorphTo
     */
    public function disputable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Returns refund for dispute
     *
     * @return HasOne
     */
    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }

    /**
    * Returns actions associated with a dispute.
    *
    * @return HasMany
    */
    public function actions(): HasMany
    {
        return $this->hasMany(DisputeAction::class);
    }
}
