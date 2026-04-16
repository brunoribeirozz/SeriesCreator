<x-layout title="Episódios" :mensagem-sucesso="$mensagemSucesso">
    <form method="post">
        @csrf
        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episódio {{ $episode->number }}

                    <input type="checkbox"
                           name="episodes[]"
                           value="{{ $episode->id }}"
                           @if ($episode->watched) checked @endif />
                </li>
            @endforeach
        </ul>

        <button class="btn btn-dark mt-2 mb-2">Salvar</button>
        <a class="btn btn-outline-secondary mt-2 mb-2" href="{{ route('series.index') }}">Voltar</a>
    </form>
</x-layout>
