<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyseFile;
use App\Models\Dataset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DatasetController extends Controller
{
    public function index(): Response {
        return Inertia::render('Datasets/Index', [
            'datasets' => \Auth::user()->datasets()
                ->select([
                    'datasets.id',
                    'datasets.filename',
                    'datasets.created_at',
                    'datasets.row_count',
                    'datasets.columns_count',
                ])
                ->paginate(10)
            ->withQueryString(),
            'userId' => \Auth::id(),
        ]);
    }

    public function create(): Response {
        return Inertia::render('Datasets/Create', [
            'userId' => \Auth::id(),
        ]);
    }

    public function store(Request $request): RedirectResponse {

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');

        $path = $file->store('datasets', 'public');

        AnalyseFile::dispatch(\Auth::user(), $file->getClientOriginalName(), $path);

        return back()->with([
            'message' => [
                'title' => 'We received your file',
                'description' => 'Your dataset is being stored.'
            ],
        ]);
    }

    public function show(Dataset $dataset): Response {
        return Inertia::render('Datasets/Show', [
            'dataset' => $dataset,
            'userId' => \Auth::id(),
        ]);
    }
}
