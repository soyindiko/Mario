<?php

namespace App\Http\Controllers;

use App\Models\AlimentoCine;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlimentoCineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $alimentosCines = AlimentoCine::paginate(50);

        $resultResponse->setResult($alimentosCines);
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
            $alimentoCine = AlimentoCine::findOrFail($id);

            $resultResponse->setResult($alimentoCine);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_cine with that ID.');
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
            'id_alimento' => 'bail|required|integer|exists:alimentos,id',
            'id_cine' => 'bail|required|integer|exists:cines,id',
            'unidades' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_alimento') . ' ' . 
                $validator->errors()->first('id_cine') . ' ' .
                $validator->errors()->first('unidades'));
            return response()->json($resultResponse);
        }

        try {
            $newAlimentoCine = new AlimentoCine;
            $newAlimentoCine->id_alimento = $request->id_alimento;
            $newAlimentoCine->id_cine = $request->id_cine;
            $newAlimentoCine->unidades = $request->unidades;
            $newAlimentoCine->save();

            $resultResponse->setResult($newAlimentoCine);
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
            'id_alimento' => 'bail|required|integer|exists:alimentos,id',
            'id_cine' => 'bail|required|integer|exists:cines,id',
            'unidades' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_alimento') . ' ' . 
                $validator->errors()->first('id_cine') . ' ' .
                $validator->errors()->first('unidades'));
            return response()->json($resultResponse);
        }

        try {
            $alimentoCine = AlimentoCine::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_cine with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimentoCine->id_alimento = $request->id_alimento;
            $alimentoCine->id_cine = $request->id_cine;
            $alimentoCine->unidades = $request->unidades;
            $alimentoCine->save();

            $resultResponse->setResult($alimentoCine);
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
            $alimentoCine = AlimentoCine::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_cine with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimentoCine->delete();

            $resultResponse->setResult($alimentoCine);
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
            if ($request->id_alimento) { 
                $searchFields[] = ['id_alimento', $request->id_alimento];
            }
            if ($request->id_cine) { 
                $searchFields[] = ['id_cine', $request->id_cine];
            }
            if ($request->unidades) { 
                $searchFields[] = ['unidades', $request->unidades];
            }
            $alimentosCines = AlimentoCine::where($searchFields)->paginate(50);

            $resultResponse->setResult($alimentosCines);
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
                                ['id_alimento', 'like', '%'.$request->texto_libre.'%'],
                                ['id_cine', 'like', '%'.$request->texto_libre.'%'],
                                ['unidades', 'like', '%'.$request->texto_libre.'%']];
            }
            $alimentosCines = AlimentoCine::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($alimentosCines);
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
