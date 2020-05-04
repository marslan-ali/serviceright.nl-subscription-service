<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Item.
 *
 * @package namespace App\Entities;
 */
class Item extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department', 'name', 'description', 'active',
        'amount', 'currency', 'tax_rate'];

}
