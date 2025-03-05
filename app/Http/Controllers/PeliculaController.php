<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Utils\ResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $resultResponse = new ResultResponse();

        $peliculas = Pelicula::paginate(50);

        $resultResponse->setResult($peliculas);
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
            $pelicula = Pelicula::findOrFail($id);

            $resultResponse->setResult($pelicula);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setStatusName(ResultResponse::SUCCESS_NAME);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no pelicula with that ID.');
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
            'titulo' => 'bail|required|string|max:200',
            'generos' => 'bail|nullable|string|max:200',
            'director' => 'bail|nullable|string|max:100',
            'actores' => 'bail|nullable|string|max:500',
            'sinopsis' => 'bail|nullable|string|max:10000',
            'url_portada' => 'bail|nullable|string|max:500',
            'url_trailer' => 'bail|nullable|string|max:500',
            'fecha_estreno' => 'bail|nullable|date',
            'estrenada' => 'bail|required|boolean',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('titulo') . ' ' . 
                $validator->errors()->first('generos') . ' ' . 
                $validator->errors()->first('director') . ' ' .
                $validator->errors()->first('actores') . ' ' .
                $validator->errors()->first('sinopsis') . ' ' .
                $validator->errors()->first('url_portada') . ' ' .
                $validator->errors()->first('url_trailer') . ' ' .
                $validator->errors()->first('fecha_estreno') . ' ' .
                $validator->errors()->first('estrenada'));
            return response()->json($resultResponse);
        }

        try {
            $newPelicula = new Pelicula;
            $newPelicula->titulo = $request->titulo;
            $newPelicula->generos = $request->generos;
            $newPelicula->director = $request->director;
            $newPelicula->actores = $request->actores;
            $newPelicula->sinopsis = $request->sinopsis;
            $newPelicula->url_portada = $request->url_portada;
            $newPelicula->url_trailer = $request->url_trailer;
            $newPelicula->fecha_estreno = $request->fecha_estreno;
            $newPelicula->estrenada = $request->estrenada;
            $newPelicula->save();

            $resultResponse->setResult($newPelicula);
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
            'titulo' => 'bail|required|string|max:200',
            'generos' => 'bail|nullable|string|max:200',
            'director' => 'bail|nullable|string|max:100',
            'actores' => 'bail|nullable|string|max:500',
            'sinopsis' => 'bail|nullable|string|max:10000',
            'url_portada' => 'bail|nullable|string|max:500',
            'url_trailer' => 'bail|nullable|string|max:500',
            'fecha_estreno' => 'bail|nullable|date',
            'estrenada' => 'bail|required|boolean',
        ]);
        if ($validator->fails()) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setStatusName(ResultResponse::ERROR_NAME);
            $resultResponse->setErrorMessage(
                $validator->errors()->first('titulo') . ' ' . 
                $validator->errors()->first('generos') . ' ' . 
                $validator->errors()->first('director') . ' ' .
                $validator->errors()->first('actores') . ' ' .
                $validator->errors()->first('sinopsis') . ' ' .
                $validator->errors()->first('url_portada') . ' ' .
                $validator->errors()->first('url_trailer') . ' ' .
                $validator->errors()->first('fecha_estreno') . ' ' .
                $validator->errors()->first('estrenada'));
            return response()->json($resultResponse);
        }

        try {
            $pelicula = Pelicula::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no pelicula with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $pelicula->titulo = $request->titulo;
            $pelicula->generos = $request->generos;
            $pelicula->director = $request->director;
            $pelicula->actores = $request->actores;
            $pelicula->sinopsis = $request->sinopsis;
            $pelicula->url_portada = $request->url_portada;
            $pelicula->url_trailer = $request->url_trailer;
            $pelicula->fecha_estreno = $request->fecha_estreno;
            $pelicula->estrenada = $request->estrenada;
            $pelicula->save();

            $resultResponse->setResult($pelicula);
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
            $pelicula = Pelicula::findOrFail($id);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::NOT_FOUND_CODE);
            $resultResponse->setStatusName(ResultResponse::NOT_FOUND_NAME);
            $resultResponse->setErrorMessage('There is no pelicula with that ID.');
            return response()->json($resultResponse);
        }

        try {
            $pelicula->delete();

            $resultResponse->setResult($pelicula);
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
            if ($request->titulo) { 
                $searchFields[] = ['titulo', 'like', '%'.$request->titulo.'%'];
            }
            if ($request->generos) { 
                $searchFields[] = ['generos', 'like', '%'.$request->generos.'%'];
            }
            if ($request->director) { 
                $searchFields[] = ['director', 'like', '%'.$request->director.'%'];
            }
            if ($request->actores) { 
                $searchFields[] = ['actores', 'like', '%'.$request->actores.'%'];
            }
            if ($request->sinopsis) { 
                $searchFields[] = ['sinopsis', 'like', '%'.$request->sinopsis.'%'];
            }
            if ($request->url_portada) { 
                $searchFields[] = ['url_portada', 'like', '%'.$request->url_portada.'%'];
            }
            if ($request->url_trailer) { 
                $searchFields[] = ['url_trailer', 'like', '%'.$request->url_trailer.'%'];
            }
            if ($request->fecha_estreno) { 
                $searchFields[] = ['fecha_estreno', 'like', '%'.$request->fecha_estreno.'%'];
            }
            if ($request->estrenada) { 
                $searchFields[] = ['estrenada', $request->estrenada];
            }
            $peliculas = Pelicula::where($searchFields)->paginate(50);

            $resultResponse->setResult($peliculas);
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
                                ['titulo', 'like', '%'.$request->texto_libre.'%'],
                                ['generos', 'like', '%'.$request->texto_libre.'%'],
                                ['director', 'like', '%'.$request->texto_libre.'%'],
                                ['actores', 'like', '%'.$request->texto_libre.'%'],
                                ['sinopsis', 'like', '%'.$request->texto_libre.'%'],
                                ['url_portada', 'like', '%'.$request->texto_libre.'%'],
                                ['url_trailer', 'like', '%'.$request->texto_libre.'%'],
                                ['fecha_estreno', 'like', '%'.$request->texto_libre.'%'],
                                ['estrenada', 'like', '%'.$request->texto_libre.'%']];
            }
            $peliculas = Pelicula::orWhere($searchFields)->paginate(50);

            $resultResponse->setResult($peliculas);
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
