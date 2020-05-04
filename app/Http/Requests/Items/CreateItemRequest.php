<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MicroServiceWorld\Domain\Models\Department;

/**
 * Class CreateItemRequest
 * @package App\Http\Requests\Items
 */
class CreateItemRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasPermission('subscription-service-create-item');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $department = Department::guessByRequestHeader()->name();
        return [
            'name' => ['required',
                Rule::unique('items')->where(function ($query) use ($request, $department) {
                    $query->where('name', $request->input('name'));
                    $query->where('amount', $request->input('amount'));
                    $query->where('department', $department);
                })],
            'amount' => ['required', 'integer'],
            'tax_rate' => ['required', 'integer'],
            'currency' => ['required', 'max:3'],
        ];
    }

}
