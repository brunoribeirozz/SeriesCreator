<x-layout title="Seasons of {!! $series->nome !!}">

    <div class="d-flex justify-center">
        <img src="{{ \Storage::url($serie->cover) }}" width="100" class="img-thumbnail me-3" alt="Capa da série">


    </div>

    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}">
                    Season {{ $season->number }}
                </a>

                <span class="badge bg-secondary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>
