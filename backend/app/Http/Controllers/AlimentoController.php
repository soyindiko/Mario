<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $alimentos = Alimento::paginate(50);

        $resultResponse->setResult($alimentos);
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
            $alimento = Alimento::findOrFail($id);

            $resultResponse->setResult($alimento);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento with that ID.');
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
            'precio' => 'bail|required|numeric',
            'url_imagen' => 'bail|nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('precio') . ' ' . 
                $validator->errors()->first('url_imagen'));
            return response()->json($resultResponse);
        }

        try {
            $newAlimento = new Alimento;
            $newAlimento->nombre = $request->nombre;
            $newAlimento->precio = $request->precio;
            $newAlimento->url_imagen = $request->url_imagen;
            $newAlimento->save();

            $resultResponse->setResult($newAlimento);
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
            'precio' => 'bail|required|numeric',
            'url_imagen' => 'bail|nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('precio') . ' ' . 
                $validator->errors()->first('url_imagen'));
            return response()->json($resultResponse);
        }

        try {
            $alimento = Alimento::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimento->nombre = $request->nombre;
            $alimento->precio = $request->precio;
            $alimento->url_imagen = $request->url_imagen;
            $alimento->save();

            $resultResponse->setResult($alimento);
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
            $alimento = Alimento::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimento->delete();

            $resultResponse->setResult($alimento);
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
            if ($request->precio) { 
                $searchFields[] = ['precio', $request->precio];
            }
            if ($request->url_imagen) { 
                $searchFields[] = ['url_imagen', 'like', '%'.$request->url_imagen.'%'];
            }
            $alimentos = Alimento::where($searchFields)->paginate(50);

            $resultResponse->setResult($alimentos);
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
                                ['precio', 'like', '%'.$request->texto_libre.'%'],
                                ['url_imagen', 'like', '%'.$request->texto_libre.'%']];
            }
            $alimentos = Alimento::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($alimentos);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function joinAlimentosCines(Request $request)
    {
        $resultResponse = new ResultResponse();

        try {
            $searchFields = [];
            if ($request->id_cine) { 
                $searchFields[] = ['alimentos_cines.id_cine', $request->id_cine];
            }
            $alimentos = Alimento::join('alimentos_cines', 'alimentos.id', '=', 'alimentos_cines.id_alimento')
                                    ->where($searchFields)->orderBy('alimentos_cines.id_cine', 'asc')->orderBy('alimentos.id', 'asc')->paginate(50);

            $resultResponse->setResult($alimentos);
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
