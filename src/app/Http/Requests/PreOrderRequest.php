<?php

namespace Imrancse94\Grocery\app\Http\Requests;

use Imrancse94\Grocery\app\Rules\ReCaptcha;

class PreOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'product_id' => 'required|integer',
            'recaptchaToken' => ['required', new ReCaptcha]
        ];
    }
}
