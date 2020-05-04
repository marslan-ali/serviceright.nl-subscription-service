<?php

namespace App\Http\Requests\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateSubscriptionRequest
 * @package App\Http\Requests\Subscriptions
 */
class CreateSubscriptionRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasPermission('subscription-service-create-subscription');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model_type' => ['required'],
            'model_id' => ['required'],
            'plan_id' => ['required', 'exists:plans,id'],
            'period_start' => ['required', 'date_format:Y-m-d H:i:s'],
            'period_end' => ['required', 'date_format:Y-m-d H:i:s', 'after:period_start'],
            'discount' => ['required', 'integer'],
        ];
    }

}
