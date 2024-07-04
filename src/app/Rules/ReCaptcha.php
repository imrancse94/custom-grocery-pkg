<?php

namespace Imrancse94\Grocery\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements ValidationRule
{
    const VERIFY_URL = "https://www.google.com/recaptcha/api/siteverify";
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get(self::VERIFY_URL,[
            'secret' => config('grocery.GOOGLE_RECAPTCHA_SECRET'),
            'response' => $value
        ]);

        if (!($response->json()["success"] ?? false)) {
            $fail('Invalid token for reCaptcha.');
        }

    }
}
