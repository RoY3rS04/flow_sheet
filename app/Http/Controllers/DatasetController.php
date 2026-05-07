<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyseFile;
use App\Models\Dataset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelReader;

class DatasetController extends Controller
{
    public function index(): Response
    {

        $user = auth()->user();

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
            'datasetsMetadata' => [
                'totalDatasets' => $user->datasets()->count(),
                'totalRows' => $user->datasets()
                    ->sum('row_count'),
                'avgColumns' => (float) $user->datasets()
                    ->avg('columns_count') ?? 0,
            ],
            'userId' => \Auth::id(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Datasets/Create', [
            'userId' => \Auth::id(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('file');

        $path = $file->store('datasets', 'public');

        AnalyseFile::dispatch(\Auth::user(), $file->getClientOriginalName(), $path);

        return back()->with([
            'message' => [
                'title' => 'We received your file',
                'description' => 'Your dataset is being stored.',
            ],
        ]);
    }

    public function show(Dataset $dataset, Request $request): Response
    {

        $validated = $request->validate([
            'skip' => ['integer', 'min:0'],
            'take' => ['integer', 'min:1'],
        ]);

        $skip = (int) ($validated['skip'] ?? 0);
        $take = (int) ($validated['take'] ?? 20);

        $rows = SimpleExcelReader::create(
            \Storage::disk('public')->path($dataset->file_url)
        )
            ->skip($skip)
            ->take($take)
            ->getRows()
            ->map(function ($row, $idx) use ($skip) {
                return [
                    'values' => [
                        ...$row
                    ],
                    'row_number' => $skip + $idx + 1,
                ];
            });

        return Inertia::render('Datasets/Show', [
            'dataset' => $dataset,
            'rows' => [
                'data' => $rows->toArray(),
                'currentPage' => ($rows->count() - $skip) / $take,
                'from' => $skip + 1,
                'lastPage' => (int) ceil($dataset->row_count / $take),
                'nextPageUrl' => $request->url() . '?skip=' . ($skip + $take) . '&take=' . $take,
                'perPage' => $take,
                'prevPageUrl' => $request->url() . '?skip=' . ($skip - $take) . '&take=' . $take,
                'to' => $skip + $take,
                'total' => $dataset->row_count,
            ],
            'userId' => \Auth::id(),
        ]);
    }

    public function destroy(Dataset $dataset): RedirectResponse
    {
        $dataset->delete();

        return to_route('datasets.index')->with([
            'message' => [
                'title' => 'Your dataset has been deleted',
            ],
        ]);
    }
}
