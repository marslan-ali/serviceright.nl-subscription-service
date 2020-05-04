<?php

namespace App\Http\Controllers\Items;

use App\Events\Item\ItemHasBeenCreated;
use App\Http\Requests\Items\CreateItemRequest;
use App\Http\Resources\ItemResource;
use Carbon\Carbon;
use MicroServiceWorld\Domain\Models\Department;

/**
 * Class CreateItem
 * @package App\Http\Controllers\Items
 */
class CreateItem extends ItemController
{
    /**
     * @param CreateItemRequest $request
     */
    public function __invoke(CreateItemRequest $request)
    {
        $itemData = $request->only([
            'name', 'amount', 'description', 'currency', 'tax_rate'
        ]);
        $itemData['department'] = Department::guessByRequestHeader()->name();
        $itemData['active'] = Carbon::now();
        $item = $this->contract->create($itemData);

        event(new ItemHasBeenCreated($item));

        return new ItemResource($item);
    }
}
