<?php

namespace App\Http\Controllers\Plans;

use App\Core\Infrastructure\Repositories\Contract\PlanRepository;
use App\Http\Controllers\Controller;

/**
 * Class PlanController
 * @package App\Http\Controllers\Plans
 */
abstract class PlanController extends Controller
{
    /**
     * @var PlanRepository
     */
    protected $contract;

    /**
     * PlanController constructor.
     * @param PlanRepository $contract
     */
    public function __construct(PlanRepository $contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return PlanRepository
     */
    public function getContract(): PlanRepository
    {
        return $this->contract;
    }
}
