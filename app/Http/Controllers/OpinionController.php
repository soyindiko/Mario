<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpinionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $opiniones = Opinion::paginate(50);

        $resultResponse->setResult($opiniones);
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
            $opinion = Opinion::findOrFail($id);

            $resultResponse->setResult($opinion);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no opinion with that ID.');
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
            'puntuacion' => 'bail|required|integer|gte:1|lte:5',
            'texto' => 'bail|nullable|string|max:1000',
            'id_cliente' => 'bail|required|integer|exists:clientes,id',
            'id_pelicula' => 'bail|required|integer|exists:peliculas,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('puntuacion') . ' ' . 
                $validator->errors()->first('texto') . ' ' . 
                $validator->errors()->first('id_cliente') . ' ' .
                $validator->errors()->first('id_pelicula'));
            return response()->json($resultResponse);
        }

        try {
            $newOpinion = new Opinion;
            $newOpinion->puntuacion = $request->puntuacion;
            $newOpinion->texto = $request->texto;
            $newOpinion->id_cliente = $request->id_cliente;
            $newOpinion->id_pelicula = $request->id_pelicula;
            $newOpinion->save();

            $resultResponse->setResult($newOpinion);
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
            'puntuacion' => 'bail|required|integer|gte:1|lte:5',
            'texto' => 'bail|nullable|string|max:1000',
            'id_cliente' => 'bail|required|integer|exists:clientes,id',
            'id_pelicula' => 'bail|required|integer|exists:peliculas,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('puntuacion') . ' ' . 
                $validator->errors()->first('texto') . ' ' . 
                $validator->errors()->first('id_cliente') . ' ' .
                $validator->errors()->first('id_pelicula'));
            return response()->json($resultResponse);
        }

        try {
            $opinion = Opinion::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no opinion with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $opinion->puntuacion = $request->puntuacion;
            $opinion->texto = $request->texto;
            $opinion->id_cliente = $request->id_cliente;
            $opinion->id_pelicula = $request->id_pelicula;
            $opinion->save();

            $resultResponse->setResult($opinion);
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
            $opinion = Opinion::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no opinion with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $opinion->delete();

            $resultResponse->setResult($opinion);
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
            if ($request->puntuacion) { 
                $searchFields[] = ['puntuacion', $request->puntuacion];
            }
            if ($request->texto) { 
                $searchFields[] = ['texto', 'like', '%'.$request->texto.'%'];
            }
            if ($request->id_cliente) { 
                $searchFields[] = ['id_cliente', $request->id_cliente];
            }
            if ($request->id_pelicula) { 
                $searchFields[] = ['id_pelicula', $request->id_pelicula];
            }
            $opiniones = Opinion::where($searchFields)->paginate(50);

            $resultResponse->setResult($opiniones);
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
                                ['puntuacion', 'like', '%'.$request->texto_libre.'%'],
                                ['texto', 'like', '%'.$request->texto_libre.'%'],
                                ['id_cliente', 'like', '%'.$request->texto_libre.'%'],
                                ['id_pelicula', 'like', '%'.$request->texto_libre.'%']];
            }
            $opiniones = Opinion::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($opiniones);
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
