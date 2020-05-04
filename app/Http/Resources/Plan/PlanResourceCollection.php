<?php

namespace App\Http\Resources\Plan;

use App\Http\Resources\PlanResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PlanResourceCollection
 * @package App\Http\Resources\Plan
 */
class PlanResourceCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = PlanResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
