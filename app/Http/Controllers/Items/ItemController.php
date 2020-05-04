<?php

namespace App\Http\Controllers\Items;

use App\Core\Infrastructure\Repositories\Contract\ItemRepository;
use App\Http\Controllers\Controller;

/**
 * Class ItemController
 * @package App\Http\Controllers\Items
 */
abstract class ItemController extends Controller
{
    /**
     * @var ItemRepository
     */
    protected $contract;

    /**
     * ItemController constructor.
     * @param ItemRepository $contract
     */
    public function __construct(ItemRepository $contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return ItemRepository
     */
    public function getContract(): ItemRepository
    {
        return $this->contract;
    }
}
