<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreModuleDefinitionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $fields = 'type,unique,required,mask,placeHolder,name,width,configurable,deleted';

        return [
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:module_definitions,reference',
            'schema_json' => 'required|array|min:1',
            'schema_json.*' => "required|array:{$fields}",
            // Regras para cada campo dentro de cada item
            'schema_json.*.type' => 'required|string|in:string,int,boolean,float,text',
            'schema_json.*.unique' => 'required|boolean|in:0,1',
            'schema_json.*.required' => 'required|boolean|in:0,1',
            'schema_json.*.mask' => 'nullable|string',
            'schema_json.*.placeHolder' => 'nullable|string',
            'schema_json.*.name' => 'required|string',
            'schema_json.*.width' => 'required|integer|min:1|max:12',
            'schema_json.*.configurable'=> 'required|boolean|in:0,1',
            'schema_json.*.deleted' => 'required|boolean|in:0,1',
        ];
    }
    public function messages(): array
    {
        return [
            'schema_json.*.array' => 'Cada campo em schema_json deve ser um objeto com os campos exatos.',
            'schema_json.*'       => 'O campo :attribute deve conter exatamente: type, unique, required, mask, placeHolder, name, width, configurable e deleted.',
        ];
    }
}
