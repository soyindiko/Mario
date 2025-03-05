<?php

namespace App\Http\Controllers;

use App\Models\AlimentoVenta;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlimentoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $alimentosVentas = AlimentoVenta::paginate(50);

        $resultResponse->setResult($alimentosVentas);
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
            $alimentoVenta = AlimentoVenta::findOrFail($id);

            $resultResponse->setResult($alimentoVenta);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_venta with that ID.');
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
            'id_venta' => 'bail|required|integer|exists:ventas,id',
            'unidades' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_alimento') . ' ' . 
                $validator->errors()->first('id_venta') . ' ' .
                $validator->errors()->first('unidades'));
            return response()->json($resultResponse);
        }

        try {
            $newAlimentoVenta = new AlimentoVenta;
            $newAlimentoVenta->id_alimento = $request->id_alimento;
            $newAlimentoVenta->id_venta = $request->id_venta;
            $newAlimentoVenta->unidades = $request->unidades;
            $newAlimentoVenta->save();

            $resultResponse->setResult($newAlimentoVenta);
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
            'id_venta' => 'bail|required|integer|exists:ventas,id',
            'unidades' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_alimento') . ' ' . 
                $validator->errors()->first('id_venta') . ' ' .
                $validator->errors()->first('unidades'));
            return response()->json($resultResponse);
        }

        try {
            $alimentoVenta = AlimentoVenta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimentoVenta->id_alimento = $request->id_alimento;
            $alimentoVenta->id_venta = $request->id_venta;
            $alimentoVenta->unidades = $request->unidades;
            $alimentoVenta->save();

            $resultResponse->setResult($alimentoVenta);
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
            $alimentoVenta = AlimentoVenta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no alimento_venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $alimentoVenta->delete();

            $resultResponse->setResult($alimentoVenta);
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
            if ($request->id_venta) { 
                $searchFields[] = ['id_venta', $request->id_venta];
            }
            if ($request->unidades) { 
                $searchFields[] = ['unidades', $request->unidades];
            }
            $alimentosVentas = AlimentoVenta::where($searchFields)->paginate(50);

            $resultResponse->setResult($alimentosVentas);
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
                                ['id_venta', 'like', '%'.$request->texto_libre.'%'],
                                ['unidades', 'like', '%'.$request->texto_libre.'%']];
            }
            $alimentosVentas = AlimentoVenta::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($alimentosVentas);
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
