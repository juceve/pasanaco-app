<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasanacoScheduleChangeRequest extends FormRequest
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
			'pasanaco_schedule_id' => 'required',
			'action' => 'required|string',
			'details' => 'string',
			'changed_at' => 'required',
        ];
    }
}
