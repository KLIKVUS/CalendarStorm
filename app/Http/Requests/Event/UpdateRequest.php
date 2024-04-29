<?php

namespace App\Http\Requests\Event;

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

            'name' => ['filled', 'string'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'color' => ['filled', 'string'],

            'beginning' => ['filled', 'date'],
            'ending' => ['filled', 'date'],
        ];
    }
}
