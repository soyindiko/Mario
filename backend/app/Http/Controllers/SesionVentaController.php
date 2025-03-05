<?php

namespace App\Http\Controllers;

use App\Models\SesionVenta;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SesionVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $sesionesVentas = SesionVenta::paginate(50);

        $resultResponse->setResult($sesionesVentas);
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
            $sesionVenta = SesionVenta::findOrFail($id);

            $resultResponse->setResult($sesionVenta);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion_venta with that ID.');
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
            'id_sesion' => 'bail|required|integer|exists:sesiones,id',
            'id_venta' => 'bail|required|integer|exists:ventas,id',
            'num_entradas' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_sesion') . ' ' . 
                $validator->errors()->first('id_venta') . ' ' .
                $validator->errors()->first('num_entradas'));
            return response()->json($resultResponse);
        }

        try {
            $newSesionVenta = new SesionVenta;
            $newSesionVenta->id_sesion = $request->id_sesion;
            $newSesionVenta->id_venta = $request->id_venta;
            $newSesionVenta->num_entradas = $request->num_entradas;
            $newSesionVenta->save();

            $resultResponse->setResult($newSesionVenta);
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
            'id_sesion' => 'bail|required|integer|exists:sesiones,id',
            'id_venta' => 'bail|required|integer|exists:ventas,id',
            'num_entradas' => 'bail|required|integer|gte:0',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('id_sesion') . ' ' . 
                $validator->errors()->first('id_venta') . ' ' .
                $validator->errors()->first('num_entradas'));
            return response()->json($resultResponse);
        }

        try {
            $sesionVenta = SesionVenta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion_venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sesionVenta->id_sesion = $request->id_sesion;
            $sesionVenta->id_venta = $request->id_venta;
            $sesionVenta->num_entradas = $request->num_entradas;
            $sesionVenta->save();

            $resultResponse->setResult($sesionVenta);
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
            $sesionVenta = SesionVenta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion_venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sesionVenta->delete();

            $resultResponse->setResult($sesionVenta);
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
            if ($request->id_sesion) { 
                $searchFields[] = ['id_sesion', $request->id_sesion];
            }
            if ($request->id_venta) { 
                $searchFields[] = ['id_venta', $request->id_venta];
            }
            if ($request->num_entradas) { 
                $searchFields[] = ['num_entradas', $request->num_entradas];
            }
            $sesionesVentas = SesionVenta::where($searchFields)->paginate(50);

            $resultResponse->setResult($sesionesVentas);
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
                                ['id_sesion', 'like', '%'.$request->texto_libre.'%'],
                                ['id_venta', 'like', '%'.$request->texto_libre.'%'],
                                ['num_entradas', 'like', '%'.$request->texto_libre.'%']];
            }
            $sesionesVentas = SesionVenta::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($sesionesVentas);
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
