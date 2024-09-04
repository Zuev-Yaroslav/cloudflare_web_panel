<?php

namespace App\Http\Requests\Domain;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRuleRequest extends FormRequest
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
            'actions' => 'required|array',
            'actions.*.id' => 'required|string',
            'actions.*.value' => 'required|string',

            'targets' => 'required|array',
            'targets.*.constraint.value' => 'required|string',
        ];
    }
    protected function passedValidation()
    {
        $data = $this->validated();
        $data['status'] = 'active';
        $data['targets'][0]['target'] = 'url';
        foreach ($data['targets'] as $key => $target) {
            $data['targets'][$key]['constraint']['operator'] = 'matches';
        }
        foreach ($data['actions'] as $key => $action) {
            $data['actions'][$key]['value'] = is_numeric($action['value']) ? (int)$action['value'] : $action['value'];
        }
        $this->replace($data);
    }
}
