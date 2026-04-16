<x-layout title="Edit Serie '{!! $serie->nome !!}'">

    <form action="{{ route('series.update', $serie->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3 mt-3">
            <div class="col-8">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') ?? $serie->nome }}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Seasons:</label>
                <input type="number" name="seasonsQty" id="seasonsQty" class="form-control"
                       value="{{ old('seasonsQty') ?? $serie->seasons->count() }}">
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Eps/Season:</label>
                <input type="number" name="episodesPerSeason" id="episodesPerSeason" class="form-control"
                       value="{{ old('episodesPerSeason') ?? $serie->seasons->first()?->episodes->count() }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="cover" class="form-label">Capa</label>
                <input type="file" id="cover" name="cover" class="form-control" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn btn-dark">Update</button>
    </form>
</x-layout>
