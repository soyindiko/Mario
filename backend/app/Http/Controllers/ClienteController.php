<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $clientes = Cliente::paginate(50);

        $resultResponse->setResult($clientes);
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
            $cliente = Cliente::findOrFail($id);

            $resultResponse->setResult($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no cliente with that ID.');
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
            'nombre' => 'bail|required|string|max:200',
            'apellidos' => 'bail|required|string|max:300',
            'id_usuario' => 'bail|required|integer|exists:usuarios,id|unique:clientes,id_usuario'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('apellidos') . ' ' . 
                $validator->errors()->first('id_usuario'));
            return response()->json($resultResponse);
        }

        try {
            $newCliente = new Cliente;
            $newCliente->nombre = $request->nombre;
            $newCliente->apellidos = $request->apellidos;
            $newCliente->id_usuario = $request->id_usuario;
            $newCliente->save();

            $resultResponse->setResult($newCliente);
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
            'nombre' => 'bail|required|string|max:200',
            'apellidos' => 'bail|required|string|max:300',
            'id_usuario' => 'bail|required|integer|exists:usuarios,id'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('apellidos') . ' ' . 
                $validator->errors()->first('id_usuario'));
            return response()->json($resultResponse);
        }

        try {
            $cliente = Cliente::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no cliente with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $cliente->nombre = $request->nombre;
            $cliente->apellidos = $request->apellidos;
            $cliente->id_usuario = $request->id_usuario;
            $cliente->save();

            $resultResponse->setResult($cliente);
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
            $cliente = Cliente::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no cliente with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $cliente->delete();

            $resultResponse->setResult($cliente);
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
            if ($request->nombre) { 
                $searchFields[] = ['nombre', 'like', '%'.$request->nombre.'%'];
            }
            if ($request->apellidos) { 
                $searchFields[] = ['apellidos', 'like', '%'.$request->apellidos.'%'];
            }
            if ($request->id_usuario) { 
                $searchFields[] = ['id_usuario', $request->id_usuario];
            }
            $clientes = Cliente::where($searchFields)->paginate(50);

            $resultResponse->setResult($clientes);
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
                                ['nombre', 'like', '%'.$request->texto_libre.'%'],
                                ['apellidos', 'like', '%'.$request->texto_libre.'%'],
                                ['id_usuario', 'like', '%'.$request->texto_libre.'%']];
            }
            $clientes = Cliente::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($clientes);
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
