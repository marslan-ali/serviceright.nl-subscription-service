<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MicroServiceWorld\Domain\Models\Department;

/**
 * Class CreatePlanRequest
 * @package App\Http\Requests\Plans
 */
class CreatePlanRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasPermission('subscription-service-create-plan');
    }

    /**
     * @param Request $request
     * @return array[]
     */
    public function rules(Request $request)
    {
        $department = Department::guessByRequestHeader();
        return [
            'name' => ['required', Rule::unique('plans')->where(function ($query) use ($request, $department) {
                return $query->where(function ($whereQuery) use ($request, $department) {
                    $whereQuery->where('name', $request->input('name'));
                    $whereQuery->where('department', $department->name());
                });
            })],
        ];
    }

}
