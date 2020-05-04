<?php

namespace App\Http\Controllers\Subscriptions;

use App\Core\Infrastructure\Repositories\Contract\SubscriptionRepository;
use App\Http\Controllers\Controller;

abstract class SubscriptionController extends Controller
{
    /**
     * @var SubscriptionRepository
     */
    protected $contract;

    /**
     * SubscriptionController constructor.
     * @param SubscriptionRepository $contract
     */
    public function __construct(SubscriptionRepository $contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return SubscriptionRepository
     */
    protected function getContract(): SubscriptionRepository
    {
        return $this->contract;
    }
}
