<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Subscription.
 *
 * @package namespace App\Entities;
 */
class Subscription extends Model implements Transformable
{
    use TransformableTrait;

    const DEPARTMENT_VEHICLE = 'vehicles';
    const DEPARTMENT_COURIER = 'couriers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department', 'model_type', 'model_id', 'period_start', 'period_end', 'discount', 'plan_id'];

    /**
     * @var string[]
     */
    protected $dates = ['period_start', 'period_end'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plans()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        /** @var Carbon $start */
        $start = $this->period_start;

        /** @var Carbon $end */
        $end = $this->period_end;

        // check that both are in the future and in the past
        return ($start->isPast() && $end->isFuture());
    }
}
