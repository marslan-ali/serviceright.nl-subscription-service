<?php

namespace App\Http\Controllers\Subscriptions;

use App\Events\Subscription\SubscriptionHasBeenCreated;
use App\Http\Requests\Subscriptions\CreateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use MicroServiceWorld\Domain\Models\Department;

/**
 * Class CreateSubscription
 * @package App\Http\Controllers\Subscriptions
 */
class CreateSubscription extends SubscriptionController
{
    /**
     * @param CreateSubscriptionRequest $request
     * @return SubscriptionResource
     */
    public function __invoke(CreateSubscriptionRequest $request)
    {
        $subscriptionData = $request->only(['model_type', 'model_id', 'period_start',
            'period_end', 'discount', 'plan_id'
        ]);
        $subscriptionData['department'] = Department::guessByRequestHeader()->name();

        $subscription = $this->contract->create($subscriptionData);

        event(new SubscriptionHasBeenCreated($subscription));

        //Item resource to return created data
        return (new SubscriptionResource($subscription));
    }
}
