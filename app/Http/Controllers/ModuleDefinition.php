<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleDefinitionRequest;
use App\Models\ModuleDefinition as ModelsModuleDefinition;
use Illuminate\Http\Request;

class ModuleDefinition extends Controller
{
    public function store(StoreModuleDefinitionRequest $request)
    {
        $data = $request->validated();

        $data = $request->json()->all() ?? $request->all();

        try {

            $module = ModelsModuleDefinition::create($data);

            return response()->json([
                'sucess' => true,
                'message' => 'Módulo criado com sucesso!',
                'data'    => $module
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar a requisição.',
                'error'   => config('app.debug') ? $th->getMessage() : null
            ], 500);
        }
    }

    public function index() 
    {
        $modulesList = ModelsModuleDefinition::get();

        return response()->json([
            'sucess' => true,
            'data'    => $modulesList
        ], 200);
    }

    public function delete(ModelsModuleDefinition $module) 
    {
        if (!$module->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Módulo não encontrado.',
            ], 404);
        }
        
        $module->delete();

        return response()->json([
            'success' => true,
            'message' => 'Módulo deletado com sucesso!',
        ], 200);
    }

    public function update(StoreModuleDefinitionRequest $request, ModelsModuleDefinition $module)
    {
        if (!$module->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Módulo não encontrado.',
            ], 404);
        } 

        $data = $request->validated();


        $data = $request->json()->all() ?? $request->all();

        try {

            $module->update($data);

            return response()->json([
                'sucess' => true,
                'message' => 'Módulo atualizado com sucesso!',
                'data'    => $module
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar a requisição.',
                'error'   => config('app.debug') ? $th->getMessage() : null
            ], 500);

        }

    }
}
