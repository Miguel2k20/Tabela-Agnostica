<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DynamicRecord as ModelsDynamicRecord;
use App\Models\ModuleDefinition;
use Illuminate\Http\Request;

class DynamicRecord extends Controller
{
    public function store(Request $request, ModuleDefinition $module) 
    {
        if (!$module->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Módulo não encontrado.',
            ], 404);
        }

        try {
            $schema = $module->schema_json;
            $rules = [];


            foreach ($schema as $fieldName => $field) 
            {
                $rule = [];

                $rule[] = ($field['required'] ?? false) ? 'required' : 'nullable';
                
                switch ($field['type'] ?? 'string') {
                    case 'string':
                    case 'text':
                        $rule[] = 'string';
                        $rule[] = 'max:255';
                        break;

                    case 'int':
                    case 'integer':
                        $rule[] = 'integer';
                        break;

                    case 'float':
                        $rule[] = 'numeric';
                        break;

                    case 'boolean':
                        $rule[] = 'boolean';
                        break;

                    case 'date':
                        $rule[] = 'date_format:d/m/Y';
                        break;

                    case 'enum':
                        $rule[] = 'string';
                        break;

                    default:
                        $rule[] = 'string';
                        break;
                }
                $rules[$fieldName] = $rule;
            }
                
            $validated = $request->validate($rules);


            $record = ModelsDynamicRecord::create([
                'reference' => $module->reference,
                'dados' => $validated 
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registro criado com sucesso.',
                'data' => $record
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar registro: ' . $e->getMessage(),
            ], 400);
        }
    }
    public function index(ModuleDefinition $module) 
    {
        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'Parâmetro "reference" é obrigatório.',
            ], 400);
        }

        $records = ModelsDynamicRecord::where('reference', $module->reference)->get();

        return response()->json([
            'success' => true,
            'data' => $records
        ], 200);
    }

    public function show(ModelsDynamicRecord $dynamicRecord)
    {

        if(!$dynamicRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Registro não encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dynamicRecord
        ], 200);
    }


    public function delete(ModelsDynamicRecord $dynamicRecord)
    {
        if (!$dynamicRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Registro não encontrado.',
            ], 404);
        }

        $dynamicRecord->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registro deletado com sucesso.',
        ], 200);
    }
}
