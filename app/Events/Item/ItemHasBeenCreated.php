<?php

namespace App\Events\Item;

use App\Domain\Models\Item;
use App\Events\Event;

/**
 * Class ItemHasBeenCreated
 * @package App\Events\Item
 */
class ItemHasBeenCreated extends Event
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * ItemHasBeenCreated constructor.
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }
}
