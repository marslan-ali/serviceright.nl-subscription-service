<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Resources\SubscriptionResource;

class RetrieveSubscriptions extends SubscriptionController
{
    public function __invoke($type,$id)
    {
        $sub = $this->contract->retrieveSubscriptionByModelTypeUuid($type,$id);
        if (is_null($sub)) {
            abort(404);
        }
        return (new SubscriptionResource($sub));
    }
}
