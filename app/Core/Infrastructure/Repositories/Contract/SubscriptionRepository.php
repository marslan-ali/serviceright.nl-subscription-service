<?php

namespace App\Core\Infrastructure\Repositories\Contract;

use App\Domain\Models\Subscription;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SubscriptionRepository.
 *
 * @package namespace App\Repositories;
 */
interface SubscriptionRepository extends RepositoryInterface
{
    /**
     * @param string $type
     * @param string $uuid
     * @return Subscription|null
     */
    public function retrieveSubscriptionByModelTypeUuid($type, $uuid): ?Subscription;

    public function importSubscriptionFromOldRecords(Collection $subscriptions, string $department,PlanRepository $contract);
}
