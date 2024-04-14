<?php

namespace App\Rules;

use App\Models\Option;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\ValidationException;


class ValidOptions implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Convert $value to an array if it's not already
        $selectedOptions = is_array($value) ? $value : json_decode($value, true);

        if (!is_array($selectedOptions)) {
            throw ValidationException::withMessages(['selected_options' => 'One or more selected options are invalid.']);
        }

        // Check if each ID exists in the options table
        foreach ($selectedOptions as $optionId) {
            $optionExists = Option::where('id', $optionId)->exists();

            if (!$optionExists) {
                throw ValidationException::withMessages(['selected_options' => 'One or more selected options are invalid.']);
            }
        }
    }

    public function message()
    {
        return 'One or more selected options are invalid.';
    }
}
