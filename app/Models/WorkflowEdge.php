<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'workflow_id',
    'source_node_id',
    'target_node_id',
    'source_node_handle',
    'target_node_handle'
])]
class WorkflowEdge extends Model
{
    public function sourceNode(): BelongsTo
    {
        return $this->belongsTo(WorkflowNode::class, 'source_node_id', 'id');
    }

    public function targetNode(): BelongsTo
    {
        return $this->belongsTo(WorkflowNode::class, 'target_node_id', 'id');
    }

    public function workflow(): BelongsTo {
        return $this->belongsTo(Workflow::class);
    }
}
