<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $administradores = Administrador::paginate(50);

        $resultResponse->setResult($administradores);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);

        return response()->json($resultResponse);
    }

    /**
     * Display the specified resource.
     */
    public function find($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $administrador = Administrador::findOrFail($id);

            $resultResponse->setResult($administrador);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no administrador with that ID.');
        }

        return response()->json($resultResponse);
    }

    /**
     * Create a new resource.
     */
    public function create(Request $request)
    {
        $resultResponse = new ResultResponse();

        $validator = Validator::make($request->all(), [
            'puede_ver_ventas' => 'bail|required|boolean',
            'puede_agregar_alimentos' => 'bail|required|boolean',
            'id_usuario' => 'bail|required|integer|exists:usuarios,id|unique:administradores,id_usuario'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('puede_ver_ventas') . ' ' . 
                $validator->errors()->first('puede_agregar_alimentos') . ' ' . 
                $validator->errors()->first('id_usuario'));
            return response()->json($resultResponse);
        }

        try {
            $newAdministrador = new Administrador;
            $newAdministrador->puede_ver_ventas = $request->puede_ver_ventas;
            $newAdministrador->puede_agregar_alimentos = $request->puede_agregar_alimentos;
            $newAdministrador->id_usuario = $request->id_usuario;
            $newAdministrador->save();

            $resultResponse->setResult($newAdministrador);
            $resultResponse->setStatusCode(ResultResponse::CREATED_CODE);
            $resultResponse->setStatusName(ResultResponse::CREATED_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $resultResponse = new ResultResponse();

        $validator = Validator::make($request->all(), [
            'puede_ver_ventas' => 'bail|required|boolean',
            'puede_agregar_alimentos' => 'bail|required|boolean',
            'id_usuario' => 'bail|required|integer|exists:usuarios,id'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('puede_ver_ventas') . ' ' . 
                $validator->errors()->first('puede_agregar_alimentos') . ' ' . 
                $validator->errors()->first('id_usuario'));
            return response()->json($resultResponse);
        }

        try {
            $administrador = Administrador::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no administrador with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $administrador->puede_ver_ventas = $request->puede_ver_ventas;
            $administrador->puede_agregar_alimentos = $request->puede_agregar_alimentos;
            $administrador->id_usuario = $request->id_usuario;
            $administrador->save();

            $resultResponse->setResult($administrador);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resultResponse = new ResultResponse();

        try {
            $administrador = Administrador::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no administrador with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $administrador->delete();

            $resultResponse->setResult($administrador);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function search(Request $request)
    {
        $resultResponse = new ResultResponse();

        try {
            $searchFields = [];
            if ($request->puede_ver_ventas) { 
                $searchFields[] = ['puede_ver_ventas', $request->puede_ver_ventas];
            }
            if ($request->puede_agregar_alimentos) { 
                $searchFields[] = ['puede_agregar_alimentos', $request->puede_agregar_alimentos];
            }
            if ($request->id_usuario) { 
                $searchFields[] = ['id_usuario', $request->id_usuario];
            }
            $administradores = Administrador::where($searchFields)->paginate(50);

            $resultResponse->setResult($administradores);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function freeSearch(Request $request)
    {
        $resultResponse = new ResultResponse();

        try {
            $searchFields = [];
            if ($request->texto_libre) { 
                $searchFields = [['id', 'like', '%'.$request->texto_libre.'%'],
                                ['puede_ver_ventas', 'like', '%'.$request->texto_libre.'%'],
                                ['puede_agregar_alimentos', 'like', '%'.$request->texto_libre.'%'],
                                ['id_usuario', 'like', '%'.$request->texto_libre.'%']];
            }
            $administradores = Administrador::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($administradores);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }
}
