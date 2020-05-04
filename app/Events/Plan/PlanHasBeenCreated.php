<?php

namespace App\Events\Plan;

use App\Domain\Models\Plan;
use App\Events\Event;

/**
 * Class PlanHasBeenCreated
 * @package App\Events\Plan
 */
class PlanHasBeenCreated extends Event
{
    /**
     * @var Plan
     */
    protected $plan;

    /**
     * PlanHasBeenCreated constructor.
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }
}
