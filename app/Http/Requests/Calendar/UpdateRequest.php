<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->active;
    }

    public function rules(): array
    {
        return [
            'active' => ['boolean'],

            'name' => ['string'],
        ];
    }
}
