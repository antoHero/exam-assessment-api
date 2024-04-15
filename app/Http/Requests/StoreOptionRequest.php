<?php

namespace App\Http\Requests;

use App\Enums\QuestionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question_type' => ['required', 'string'],
            'content' => ['required', 'string', 'max:255'],
            'isAnswer' => ['required', 'boolean'],
        ];
    }

    /**
     * validate field for question type
    */
    public function singleChoiceValidationRule()
    {
        return function ($attribute, $value, $fail)
        {
            if($this->input('question_type') === QuestionTypeEnum::SINGLE->value)
            {
                $fail('Options cannot be added to a single choice questions.');
            }
        };
    }
}
