<?php

namespace App\Http\Resources;

use App\Domain\Models\Subscription;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SubscriptionResource
 * @package App\Http\Resources
 */
class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);

        $parent['active'] = $this->resource->isActive();
        $parent['active_from'] = $this->resource->period_start;
        $parent['active_until'] = $this->resource->period_end;

        return $parent;
    }
}
