<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormRequest $request, ?string $coverPath): Series
    {
        return DB::transaction(function () use ($request, $coverPath) {
            $serie = Series::create([
                'nome' => $request->nome,
                'cover' => $coverPath,
            ]);

            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($serie->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            Episode::insert($episodes);

            return $serie;
        });
    }
    public function remove(Series $series): void
    {
        DB::transaction(function () use ($series) {

            $series->delete();

            // 2. Deleta o arquivo físico se ele existir e não for a imagem padrão
            if ($series->cover && $series->cover !== 'series_cover/default.jpg') {
                Storage::disk('public')->delete($series->cover);
            }
        });
    }

}
