<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IndexPlanRequest
 * @package App\Http\Requests\Plans
 */
class IndexPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasPermission('subscription-service-index-plans');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
