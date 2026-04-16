<x-layout title="Series" :mensagem-sucesso="$mensagemSucesso">
    @auth
        <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Add</a>
    @endauth
<div style="max-height: 800px; overflow-y:auto;">
    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ \Storage::url($serie->cover) }}" width="100" class="img-thumbnail me-3" alt="Capa da série">


                @auth
                        <a href="{{ route('seasons.index', $serie->id) }}"> @endauth
                            {{ $serie->nome }}
                            @auth </a>
                    @endauth
                </div>

                @auth
                    <span class="d-flex">
                <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>

                <form action="{{ route('series.destroy', $serie->id) }}" method="post" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-dark btn-sm">Delete</button>
                </form>
            </span>
                @endauth
            </li>
        @endforeach
    </ul>
</div>
</x-layout>
