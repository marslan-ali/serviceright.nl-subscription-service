<?php

namespace App\Http\Controllers\Plans;

use App\Events\Plan\PlanHasBeenCreated;
use App\Http\Requests\Plans\CreatePlanRequest;
use App\Http\Resources\PlanResource;
use Illuminate\Support\Facades\Log;
use MicroServiceWorld\Domain\Models\Department;

/**
 * Class CreatePlan
 * @package App\Http\Controllers\Plans
 */
class CreatePlan extends PlanController
{
    /**
     * @param CreatePlanRequest $request
     * @return PlanResource
     */
    public function __invoke(CreatePlanRequest $request)
    {
        // create a new plan
        $planData = $request->only(['name', 'description',]);
        $planData['department'] = Department::guessByRequestHeader()->name();

        // plan
        $plan = $this->contract->create($planData);

        Log::info('Creating new plan', [
            'user' => $request->user()->getKey(),
            'plan' => $plan
        ]);

        event(new PlanHasBeenCreated($plan));

        //Plan resource to return created data
        return (new PlanResource($plan));
    }
}
