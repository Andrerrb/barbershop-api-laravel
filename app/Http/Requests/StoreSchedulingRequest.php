<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchedulingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],

            'end_date' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after:start_date',
            ],
        ];
    }
}