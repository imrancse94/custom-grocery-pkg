<?php

namespace Imrancse94\Grocery\app\Http\Requests;

class RefreshTokenRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required',
        ];
    }
}
