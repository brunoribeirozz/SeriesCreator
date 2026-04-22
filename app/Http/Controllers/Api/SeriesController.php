<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {

    }

    public function index(Request $request)
    {
        if (!$request->has('nome')){
            return Series::all();
        }

        return Series::whereNome($request->nome)->get();
    }

    public function store(SeriesFormRequest $request)
    {
        $coverPath = null;

        // ve se veio um arquivo e salva no banco (Lógica da imagem)
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover', 'public')
            : 'series_cover/sonic.gif';


        //  vai chamar o repositório passando o caminho da imagem
        $serie = $this->repository->add($request, $coverPath);

        return response()
            ->json($serie, 201);
    }

    public function show(Int $series)
    {
        $seriesModel = Series::find($series);
        if ($seriesModel === null) {
            return response()->json(['message' => 'Series not found.'], 404);
        }
        return $seriesModel;
    }

    public function update(SeriesFormRequest $request, Series $series)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(Int $series)
    {
        Series::destroy($series);

        return response()->noContent();
    }
}
