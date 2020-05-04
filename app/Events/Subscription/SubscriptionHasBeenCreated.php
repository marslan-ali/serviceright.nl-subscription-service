<?php

namespace App\Events\Subscription;

use App\Domain\Models\Subscription;
use App\Events\Event;

/**
 * Class SubscriptionHasBeenCreated
 * @package App\Events\Subscription
 */
class SubscriptionHasBeenCreated extends Event
{
    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * SubscriptionHasBeenCreated constructor.
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
