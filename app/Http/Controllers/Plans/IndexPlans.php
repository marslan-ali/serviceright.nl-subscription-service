<?php

namespace App\Http\Controllers\Plans;

use App\Http\Requests\Items\IndexPlanRequest;
use App\Http\Resources\Plan\PlanResourceCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class IndexPlans
 * @package App\Http\Controllers\Plans
 */
class IndexPlans extends PlanController
{
    /**
     * @param IndexPlanRequest $request
     * @return PlanResourceCollection
     */
    public function __invoke(IndexPlanRequest $request)
    {
        /** @var LengthAwarePaginator $plans */
        $results = $this->getContract()->orderBy('created_at', 'DESC')
            ->paginate($request->input('limit', 25));

        return (new PlanResourceCollection($plans->items()))->additional([
            'meta' => [
                'total' => $results->total(),
                'limit' => $results->perPage(),
                'page' => $results->currentPage(),
                'has_more_pages' => $results->hasMorePages(),
            ]
        ]);
    }
}
