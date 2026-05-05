<?php

namespace App\Jobs;

use App\Events\DatasetSaved;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class AnalyseFile implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private string $filename,
        private string $file_url,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $rows = SimpleExcelReader::create(
            Storage::disk('public')->path($this->file_url)
        )->getRows();

        $row_count = 0;
        $columns = [];
        $rows->each(function (array $rowProperties) use (&$columns, &$row_count) {

            $columns = array_keys($rowProperties);

            $row_count++;
        });

        $dataset = $this->user->datasets()
            ->create([
                'filename' => $this->filename,
                'file_url' => $this->file_url,
                'columns' => json_encode($columns),
                'row_count' => $row_count,
                'columns_count' => count($columns),
            ]);

        DatasetSaved::dispatch($this->user, $dataset);
    }
}
