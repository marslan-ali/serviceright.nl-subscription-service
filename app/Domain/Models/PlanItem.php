<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PlanItem.
 *
 * @package namespace App\Entities;
 */
class PlanItem extends Model implements Transformable {

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plan_id', 'item_id'];

    public $incrementing = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plans()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptions()
    {
        return $this->belongsTo(Item::class);
    }

}
