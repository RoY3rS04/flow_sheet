<?php

namespace App\Http\Controllers;

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
}
