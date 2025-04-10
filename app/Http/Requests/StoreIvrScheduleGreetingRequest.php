<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIvrScheduleGreetingRequest extends FormRequest
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
    public function rules()
    {
        return [
            'id'=>'nullable',
            'ivr_config_id' => 'required|integer',
            'start_date_time' => 'required|date',
            'end_date_time' => 'nullable|date',
            'title' => 'required|string|max:255',
            'greeting_text' => 'nullable|string',
        ];
    }
}
