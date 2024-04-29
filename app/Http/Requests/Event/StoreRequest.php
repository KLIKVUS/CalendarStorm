<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->active;
    }

    public function rules(): array
    {
        return [
            'active' => ['boolean'],

            'name' => ['required', 'string'],
            'description' => ['string'],
            'link' => ['url'],
            'color' => ['required', 'string'],

            'beginning' => ['required', 'date'],
            'ending' => ['required', 'date'],
        ];
    }
}
