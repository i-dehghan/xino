<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $config = $this->route('config', null);
        $configId = isset($config) ? $config->id : null;

        $array = [
            'key' => [
                'string',
                'required',
                'unique:configs,key,' . $configId
            ],
            'type' => [
                'required',
                Rule::in(['array', 'boolean', 'string', 'integer'])
            ]
        ];
        return $this->getValidationBaseType($array);
    }

    public function bodyParameters()
    {
        return [
            'key' => [
                'description' => 'key of config',
                'required' => true,
            ],
            'value' => [
                'description' => 'value of config',
                'required' => true,
            ],
            'type' => [
                'description' => 'type of config (boolean,array,string,integer)',
                'required' => true,
            ],
        ];

    }

    protected function prepareForValidation()
    {
        if ($this->type == 'boolean') {
            $this->value = ($this->value == 'false' || $this->value == '0') ? false : $this->value;
            $this->value = ($this->value == 'true' || $this->value == '1') ? false : $this->value;
        }
        $this->merge([
            'key' => strip_tags($this->key),
            'value' => $this->value
        ]);
    }

    public function getValidationBaseType(array $array): array
    {
        switch ($this->type) {
            case 'boolean':
                $array = array_merge($array, [
                    'value' => 'required|boolean',
                ]);
                break;
            case 'integer':
                $array = array_merge($array, [
                    'value' => 'required|integer',
                ]);
                break;
            case 'string':
                $array = array_merge($array, [
                    'value' => 'required|string',
                ]);
                break;
            case 'array':
                $array = array_merge($array, [
                    'value' => 'required',
                ]);
                break;
        }
        return $array;
    }
}
