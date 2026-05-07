<?php

namespace App\Models;

use App\Enums\WorkflowOperationKey;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'workflow_id',
    'node_key',
    'operation_key',
    'label',
    'position_x',
    'position_y',
    'config',
])]
class WorkflowNode extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'operation_key' => WorkflowOperationKey::class,
            'config' => 'array',
        ];
    }

    public function inEdges(): HasMany
    {
        return $this->hasMany(WorkflowEdge::class, 'target_node_id', 'id');
    }

    public function outEdges(): HasMany
    {
        return $this->hasMany(WorkflowEdge::class, 'source_node_id', 'id');
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }
}
