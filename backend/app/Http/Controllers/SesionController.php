<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use App\Models\Sala;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $sesiones = Sesion::paginate(50);

        $resultResponse->setResult($sesiones);
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
            $sesion = Sesion::findOrFail($id);

            $resultResponse->setResult($sesion);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion with that ID.');
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
            'fecha' => 'bail|required|date',
            'hora' => 'bail|required|date_format:H:i:s',
            'tipo' => ['bail', 'required', 'string', 'max:15', Rule::in(['ordinaria', 'VOSE', '3D'])],
            'precio' => 'bail|required|numeric',
            'id_sala' => 'bail|required|integer|exists:salas,id',
            'id_pelicula' => 'bail|required|integer|exists:peliculas,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('fecha') . ' ' . 
                $validator->errors()->first('hora') . ' ' . 
                $validator->errors()->first('tipo') . ' ' .
                $validator->errors()->first('precio') . ' ' .
                $validator->errors()->first('id_sala') . ' ' .
                $validator->errors()->first('id_pelicula'));
            return response()->json($resultResponse);
        }

        try {
            //Al crear una sesión solo se le pasa el ID de la sala en la que tiene lugar, y de esa sala saca el aforo máximo de la sesión
            $aforoObject = Sala::select('aforo')->findOrFail($request->id_sala);

            $newSesion = new Sesion;
            $newSesion->fecha = $request->fecha;
            $newSesion->hora = $request->hora;
            $newSesion->tipo = $request->tipo;
            $newSesion->precio = $request->precio;
            $newSesion->aforo_restante = $aforoObject['aforo'];
            $newSesion->id_sala = $request->id_sala;
            $newSesion->id_pelicula = $request->id_pelicula;
            $newSesion->save();

            $resultResponse->setResult($newSesion);
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
            'fecha' => 'bail|required|date',
            'hora' => 'bail|required|date_format:H:i:s',
            'tipo' => ['bail', 'required', 'string', 'max:15', Rule::in(['ordinaria', 'VOSE', '3D'])],
            'precio' => 'bail|required|numeric',
            'aforo_restante' => 'bail|required|integer',
            'id_sala' => 'bail|required|integer|exists:salas,id',
            'id_pelicula' => 'bail|required|integer|exists:peliculas,id',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('fecha') . ' ' . 
                $validator->errors()->first('hora') . ' ' . 
                $validator->errors()->first('tipo') . ' ' .
                $validator->errors()->first('precio') . ' ' .
                $validator->errors()->first('aforo_restante') . ' ' .
                $validator->errors()->first('id_sala') . ' ' .
                $validator->errors()->first('id_pelicula'));
            return response()->json($resultResponse);
        }

        try {
            $sesion = Sesion::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sesion->fecha = $request->fecha;
            $sesion->hora = $request->hora;
            $sesion->tipo = $request->tipo;
            $sesion->precio = $request->precio;
            $sesion->aforo_restante = $request->aforo_restante;
            $sesion->id_sala = $request->id_sala;
            $sesion->id_pelicula = $request->id_pelicula;
            $sesion->save();

            $resultResponse->setResult($sesion);
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
            $sesion = Sesion::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no sesion with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $sesion->delete();

            $resultResponse->setResult($sesion);
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
            if ($request->fecha) { 
                $searchFields[] = ['fecha', 'like', '%'.$request->fecha.'%'];
            }
            if ($request->hora) { 
                $searchFields[] = ['hora', 'like', '%'.$request->hora.'%'];
            }
            if ($request->tipo) { 
                $searchFields[] = ['tipo', 'like', '%'.$request->tipo.'%'];
            }
            if ($request->precio) { 
                $searchFields[] = ['precio', $request->precio];
            }
            if ($request->aforo_restante) { 
                $searchFields[] = ['aforo_restante', $request->aforo_restante];
            }
            if ($request->id_sala) { 
                $searchFields[] = ['id_sala', $request->id_sala];
            }
            if ($request->id_pelicula) { 
                $searchFields[] = ['id_pelicula', $request->id_pelicula];
            }
            $sesiones = Sesion::where($searchFields)->paginate(50);

            $resultResponse->setResult($sesiones);
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
                                ['fecha', 'like', '%'.$request->texto_libre.'%'],
                                ['hora', 'like', '%'.$request->texto_libre.'%'],
                                ['tipo', 'like', '%'.$request->texto_libre.'%'],
                                ['precio', 'like', '%'.$request->texto_libre.'%'],
                                ['aforo_restante', 'like', '%'.$request->texto_libre.'%'],
                                ['id_sala', 'like', '%'.$request->texto_libre.'%'],
                                ['id_pelicula', 'like', '%'.$request->texto_libre.'%']];
            }
            $sesiones = Sesion::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($sesiones);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function joinSalas()
    {
        $resultResponse = new ResultResponse();

        try {
            $sesiones = Sesion::join('salas', 'sesiones.id_sala', '=', 'salas.id')->paginate(50);

            $resultResponse->setResult($sesiones);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage($e->getMessage());
        }

        return response()->json($resultResponse);
    }

    public function joinPeliculasCinesSearch(Request $request)
    {
        $resultResponse = new ResultResponse();

        try {
            $searchFields = [];
            if ($request->id_pelicula) { 
                $searchFields[] = ['peliculas.id', $request->id_pelicula];
            }
            if ($request->id_cine) { 
                $searchFields[] = ['cines.id', $request->id_cine];
            }
            if ($request->fecha) { 
                $searchFields[] = ['sesiones.fecha', 'like', '%'.$request->fecha.'%'];
            }
            $sesiones = Sesion::select(
                                    'sesiones.id as id_sesion',
                                    'sesiones.fecha',
                                    'sesiones.hora',
                                    'sesiones.tipo',
                                    'sesiones.precio',
                                    'sesiones.aforo_restante',
                                    'sesiones.id_pelicula',
                                    'peliculas.titulo',
                                    'peliculas.generos',
                                    'peliculas.director',
                                    'peliculas.actores',
                                    'peliculas.sinopsis',
                                    'peliculas.url_portada',
                                    'peliculas.url_trailer',
                                    'salas.id as id_sala',
                                    'salas.nombre as nombre_sala',
                                    'salas.aforo',
                                    'cines.id as id_cine',
                                    'cines.nombre as nombre_cine',
                                    'cines.direccion')
                                ->join('peliculas', 'sesiones.id_pelicula', '=', 'peliculas.id')
                                ->join('salas', 'sesiones.id_sala', '=', 'salas.id')
                                ->join('cines', 'salas.id_cine', '=', 'cines.id')
                                ->where($searchFields)
                                ->orderBy('sesiones.id', 'asc')
                                ->paginate(50);

            $resultResponse->setResult($sesiones);
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
