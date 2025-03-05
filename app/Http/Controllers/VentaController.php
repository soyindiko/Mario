<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\AlimentoVenta;
use App\Models\SesionVenta;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $ventas = Venta::paginate(50);

        $resultResponse->setResult($ventas);
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
            $venta = Venta::findOrFail($id);

            $resultResponse->setResult($venta);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no venta with that ID.');
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
            'importe' => 'bail|required|numeric',
            'fecha' => 'bail|required|date',
            'hora' => 'bail|required|date_format:H:i:s',
            'id_cliente' => 'bail|required|integer|exists:clientes,id'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('importe') . ' ' . 
                $validator->errors()->first('fecha') . ' ' . 
                $validator->errors()->first('hora') . ' ' .
                $validator->errors()->first('id_cliente'));
            return response()->json($resultResponse);
        }

        try {
            $newVenta = new Venta;
            $newVenta->importe = $request->importe;
            $newVenta->fecha = $request->fecha;
            $newVenta->hora = $request->hora;
            $newVenta->id_cliente = $request->id_cliente;
            $newVenta->save();

            $resultResponse->setResult($newVenta);
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
            'importe' => 'bail|required|numeric',
            'fecha' => 'bail|required|date',
            'hora' => 'bail|required|date_format:H:i:s',
            'id_cliente' => 'bail|required|integer|exists:clientes,id'
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('importe') . ' ' . 
                $validator->errors()->first('fecha') . ' ' . 
                $validator->errors()->first('hora') . ' ' .
                $validator->errors()->first('id_cliente'));
            return response()->json($resultResponse);
        }

        try {
            $venta = Venta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $venta->importe = $request->importe;
            $venta->fecha = $request->fecha;
            $venta->hora = $request->hora;
            $venta->id_cliente = $request->id_cliente;
            $venta->save();

            $resultResponse->setResult($venta);
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
            $venta = Venta::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no venta with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $venta->delete();

            $resultResponse->setResult($venta);
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
            if ($request->importe) { 
                $searchFields[] = ['importe', $request->importe];
            }
            if ($request->fecha) { 
                $searchFields[] = ['fecha', 'like', '%'.$request->fecha.'%'];
            }
            if ($request->hora) { 
                $searchFields[] = ['hora', 'like', '%'.$request->hora.'%'];
            }
            if ($request->id_cliente) { 
                $searchFields[] = ['id_cliente', $request->id_cliente];
            }
            $ventas = Venta::where($searchFields)->paginate(50);

            $resultResponse->setResult($ventas);
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
                                ['importe', 'like', '%'.$request->texto_libre.'%'],
                                ['fecha', 'like', '%'.$request->texto_libre.'%'],
                                ['hora', 'like', '%'.$request->texto_libre.'%'],
                                ['id_cliente', 'like', '%'.$request->texto_libre.'%']];
            }
            $ventas = Venta::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($ventas);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function fullDetail()
    {
        $resultResponse = new ResultResponse();

        try {
            $ventas = Venta::paginate(50);
            foreach ($ventas as $venta) {
                $alimentos = AlimentoVenta::where('id_venta', $venta->id)->join('alimentos', 'alimentos_ventas.id_alimento', '=', 'alimentos.id')->get();
                $venta->alimentos = $alimentos;
                $sesiones = SesionVenta::where('id_venta', $venta->id)->join('sesiones', 'sesiones_ventas.id_sesion', '=', 'sesiones.id')->get();
                $venta->sesiones = $sesiones;
            }

            $resultResponse->setResult($ventas);
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
