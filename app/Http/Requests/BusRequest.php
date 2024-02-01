<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'no'                 => ['required'],
            'seat'               => ['required', 'integer'],
            'engine_model'       => ['required'],
            'chassis_no'         => ['required'],
            'model'              => ['required'],
            'color'              => ['required'],
            'register_no'        => ['required'],
            'made_in'            => ['required'],
            'make'               => ['required'],
            'price'              => ['required'],
            'fuel'               => ['required'],
            'engine_capacity'    => ['required'],
            'puchase_year'       => ['required', 'integer'],
            'transmission_model' => ['required'],
            'status'             => ['required'],
            'driver_id'          => ['required', 'integer'],
            'conductor_id'       => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
