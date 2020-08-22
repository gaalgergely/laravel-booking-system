<?php

namespace App\Http\Requests;

use App\Bookable;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',

            /**
             * @example The ordering of the validation rules can not be set in Laravel
             * so if bookable_id is missing it will throw an exception ...
             * (ErrorException: Undefined index: bookable_id)
             */
            /*'bookings.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $bookable = Bookable::findOrFail($value['bookable_id']);

                    if (!$bookable->availableFor($value['from'], $value['to'])) {
                        $fail('The object is not available in given dates');
                    }
                }
            ],*/

            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.street' => 'required|min:3',
            'customer.city' => 'required|min:2',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:2'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /**
             * @todo move the validation from the controller to here ...
             * Maximum function nesting level of '256' reached, aborting!
             */
            /*$validator->validate([
                'bookings.*' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $bookable = Bookable::findOrFail($value['bookable_id']);

                        if (!$bookable->availableFor($value['from'], $value['to'])) {
                            $fail('The object is not available in given dates');
                        }
                    }
                ]
            ]);*/
        });
    }
}
