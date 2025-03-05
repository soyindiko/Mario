<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $usuarios = Usuario::paginate(50);

        $resultResponse->setResult($usuarios);
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
            $usuario = Usuario::findOrFail($id);

            $resultResponse->setResult($usuario);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no usuario with that ID.');
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
            'correo' => 'bail|required|string|max:200|unique:usuarios,correo',
            'contrasena' => 'bail|required|string|max:500',
            'rol' => ['bail', 'required', 'string', 'max:15', Rule::in(['cliente', 'administrador'])]
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('correo') . ' ' . 
                $validator->errors()->first('contrasena') . ' ' . 
                $validator->errors()->first('rol'));
            return response()->json($resultResponse);
        }

        try {
            $newUsuario = new Usuario;
            $newUsuario->correo = $request->correo;
            $newUsuario->contrasena = $request->contrasena;
            $newUsuario->rol = $request->rol;
            $newUsuario->save();

            $resultResponse->setResult($newUsuario);
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
            'correo' => 'bail|required|string|max:200',
            'contrasena' => 'bail|required|string|max:500',
            'rol' => ['bail', 'required', 'string', 'max:15', Rule::in(['cliente', 'administrador'])]
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('correo') . ' ' . 
                $validator->errors()->first('contrasena') . ' ' . 
                $validator->errors()->first('rol'));
            return response()->json($resultResponse);
        }

        try {
            $usuario = Usuario::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no usuario with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $usuario->correo = $request->correo;
            $usuario->contrasena = $request->contrasena;
            $usuario->rol = $request->rol;
            $usuario->save();

            $resultResponse->setResult($usuario);
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
            $usuario = Usuario::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no usuario with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $usuario->delete();

            $resultResponse->setResult($usuario);
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
            if ($request->correo) { 
                $searchFields[] = ['correo', 'like', '%'.$request->correo.'%'];
            }
            if ($request->contrasena) { 
                $searchFields[] = ['contrasena', 'like', '%'.$request->contrasena.'%'];
            }
            if ($request->rol) { 
                $searchFields[] = ['rol', 'like', '%'.$request->rol.'%'];
            }
            $usuarios = Usuario::where($searchFields)->paginate(50);

            $resultResponse->setResult($usuarios);
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
                                ['correo', 'like', '%'.$request->texto_libre.'%'],
                                ['contrasena', 'like', '%'.$request->texto_libre.'%'],
                                ['rol', 'like', '%'.$request->texto_libre.'%']];
            }
            $usuarios = Usuario::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($usuarios);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function authentication(Request $request)
    {
        $resultResponse = new ResultResponse();

        try {
            $usuario = Usuario::where([['correo', $request->correo], ['contrasena', $request->contrasena]])->firstOrFail();

            $resultResponse->setResult($usuario);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::UNAUTHORIZED_CODE);
            $resultResponse->setStatusName(ResultResponse::UNAUTHORIZED_NAME);
            $resultResponse->setErrorMessage('Wrong correo or contrasena.');
        }

        return response()->json($resultResponse);
    }
}
