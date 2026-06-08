<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchedulingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],

            'end_date' => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}