<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasanacoScheduleRequest extends FormRequest
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
			'pasanaco_group_id' => 'required',
			'scheduled_date' => 'required',
			'status' => 'required',
			'adjusted' => 'required',
			'adjustment_reason' => 'string',
        ];
    }
}
