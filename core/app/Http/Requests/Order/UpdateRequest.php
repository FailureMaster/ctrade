<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'no_of_lot' => [
                'required',
                'numeric',
            ],
            'rate' => [
               'required',
                'numeric',
            ]
        ];
    }
}