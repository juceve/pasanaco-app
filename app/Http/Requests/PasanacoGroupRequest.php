<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasanacoGroupRequest extends FormRequest
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
			'name' => 'required|string',
			'start_date' => 'required',
			'frequency' => 'required',
			'day_of_week' => 'string',
			'amount_per_participant' => 'required',
			'status' => 'required',
			'progress_percent' => 'required',
        ];
    }
}
