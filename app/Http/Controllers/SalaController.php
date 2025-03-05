<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $salas = Sala::paginate(50);

        $resultResponse->setResult($salas);
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
            $sala = Sala::findOrFail($id);

            $resultResponse->setResult($sala);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sala with that ID.');
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
            'nombre' => 'bail|required|string|max:100',
            'aforo' => 'bail|required|integer',
            'id_cine' => 'bail|required|integer|exists:cines,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('aforo') . ' ' . 
                $validator->errors()->first('id_cine'));
            return response()->json($resultResponse);
        }

        try {
            $newSala = new Sala;
            $newSala->nombre = $request->nombre;
            $newSala->aforo = $request->aforo;
            $newSala->id_cine = $request->id_cine;
            $newSala->save();

            $resultResponse->setResult($newSala);
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
            'nombre' => 'bail|required|string|max:100',
            'aforo' => 'bail|required|integer',
            'id_cine' => 'bail|required|integer|exists:cines,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('nombre') . ' ' . 
                $validator->errors()->first('aforo') . ' ' . 
                $validator->errors()->first('id_cine'));
            return response()->json($resultResponse);
        }

        try {
            $sala = Sala::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sala with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sala->nombre = $request->nombre;
            $sala->aforo = $request->aforo;
            $sala->id_cine = $request->id_cine;
            $sala->save();

            $resultResponse->setResult($sala);
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
            $sala = Sala::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sala with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sala->delete();

            $resultResponse->setResult($sala);
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
            if ($request->aforo) { 
                $searchFields[] = ['aforo', $request->aforo];
            }
            if ($request->id_cine) { 
                $searchFields[] = ['id_cine', $request->id_cine];
            }
            $salas = Sala::where($searchFields)->paginate(50);

            $resultResponse->setResult($salas);
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
                                ['aforo', 'like', '%'.$request->texto_libre.'%'],
                                ['id_cine', 'like', '%'.$request->texto_libre.'%']];
            }
            $salas = Sala::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($salas);
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
