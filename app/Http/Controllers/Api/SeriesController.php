<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SeriesFormRequest;
use App\Http\Requests\SeriesFormRequest as SeriesFormRequestAlias;
use App\Models\Series;
use Illuminate\Routing\Controller;

class SeriesController extends Controller
{
    public function index()
    {
        return Series::all();
    }
    public function store(SeriesFormRequest $request)
    {


        return response()
            ->json(Series::create($request->all()), 201);
    }
}
