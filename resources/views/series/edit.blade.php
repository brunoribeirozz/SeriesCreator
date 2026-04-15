<x-layout title="Edit Serie '{!! $serie->nome !!}'">
    <x-series.form :action="route('series.update', $serie->id)" :nome="$serie->nome" :update="true" />
</x-layout>
