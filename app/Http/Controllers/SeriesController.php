<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    # por meio do middleware, ele valida se o usuaria ta logado, se sim ele tem acesso a editar, criar, deletar
    # se não tiver, apenas a pagina de index é exibida
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware('auth')->except('index');
    }

    # Aqui o index gerencia todas as series e mostra as mensagens de sucesso
    public function index(Request $request)
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    # aqui faz as requisições de editar e criar as series
    public function create()
    {
        return view('series.create');
    }


    # salva os dados novos ou editados
    public function store(SeriesFormRequest $request)
    {
        $coverPath = $request->hasFile('cover') ? $request->file('cover')
                ->store('series_cover', 'public') : null;

        $serie = $this->repository->add($request, $coverPath);
        $seriesCreatedEvent = new \App\Events\SeriesCreated(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason,
            $serie->cover,
        );
        event($seriesCreatedEvent);


        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    # função de deletar, busca no banco e faz o delete
    public function destroy(Series $series)
    {
        $this->repository->remove($series);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());

        if ($request->hasFile('cover')) {


            $path = $request->file('cover')
                ->store('series_cover', 'public');
            $series->cover = $path;
        }

        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada");
    }

}
