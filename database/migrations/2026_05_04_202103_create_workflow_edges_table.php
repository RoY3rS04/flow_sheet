<?php

use App\Models\Workflow;
use App\Models\WorkflowNode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflow_edges', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workflow::class)->constrained();
            $table->foreignIdFor(WorkflowNode::class, 'source_node_id')
                ->constrained();
            $table->foreignIdFor(WorkflowNode::class, 'target_node_id')
                ->constrained();
            $table->string('source_node_handle')->nullable();
            $table->string('target_node_handle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_edges');
    }
};
