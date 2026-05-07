<?php

use App\Models\Dataset;
use App\Models\Workflow;
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
        Schema::create('workflow_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workflow::class)->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Dataset::class)->constrained()
                ->cascadeOnDelete();
            $table->string('status');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->string('output_path')->nullable();
            $table->integer('input_row_count')->nullable();
            $table->integer('output_row_count')->nullable();
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_runs');
    }
};
