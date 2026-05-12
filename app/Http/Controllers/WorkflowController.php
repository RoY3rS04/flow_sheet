<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkflowController extends Controller
{
    public function index(): Response
    {

        $user = auth()->user();

        return Inertia::render('Workflows/Index', [
            'workflows' => $user->workflows()
                ->paginate(10),
            'userId' => $user->id,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Workflows/Create', [
            'userId' => auth()->user()->id,
        ]);
    }

    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'workflowInfo.name' => ['required', 'string', 'max:255'],
            'workflowInfo.description' => ['nullable', 'string'],
            'nodes' => ['required', 'array', 'min:1'],
            'nodes.*.data' => ['nullable', 'array'],
            'nodes.*.id' => ['required', 'string'],
            'nodes.*.type' => ['required', 'string'],
            'nodes.*.position' => ['required', 'array'],
            'edges' => ['required', 'array'],
            'edges.*.id' => ['required', 'string'],
            'edges.*.source' => ['required', 'string'],
            'edges.*.target' => ['required', 'string'],
            'edges.*.sourceHandle' => ['nullable', 'string'],
            'edges.*.targetHandle' => ['nullable', 'string'],
        ]);

        dd($validated);
    }
}
