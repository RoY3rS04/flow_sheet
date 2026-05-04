<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'dataset_id',
    'workflow_id',
    'status',
    'started_at',
    'finished_at',
    'input_row_count',
    'output_row_count',
    'output_path'
])]
class WorkflowRun extends Model
{
    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }
}
