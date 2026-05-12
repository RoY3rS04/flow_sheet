<?php

namespace App\Jobs;

use App\Events\DatasetSaved;
use App\Models\User;
use DateTimeInterface;
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
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = Storage::disk('public')->path($this->file_url);
        $headers = SimpleExcelReader::create($path)->getHeaders();
        $sampleRows = SimpleExcelReader::create($path)
            ->take(25)
            ->getRows()
            ->all();

        $columns = array_map(function (string $header) use ($sampleRows) {
            return [
                'name' => $header,
                'type' => $this->inferColumnType($sampleRows, $header),
            ];
        }, $headers);

        $rowCount = SimpleExcelReader::create($path)->getRows()->count();

        $dataset = $this->user->datasets()
            ->create([
                'filename' => $this->filename,
                'file_url' => $this->file_url,
                'columns' => json_encode($columns),
                'row_count' => $rowCount,
                'columns_count' => count($columns),
            ]);

        DatasetSaved::dispatch($this->user, $dataset);
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     */
    private function inferColumnType(array $rows, string $header): string
    {
        if ($this->isBooleanColumn($rows, $header)) {
            return 'boolean';
        }

        $types = collect($rows)
            ->map(fn (array $row): string => $this->inferValueType($row[$header] ?? null))
            ->reject(fn (string $type): bool => $type === 'null')
            ->unique()
            ->values();

        if ($types->isEmpty()) {
            return 'string';
        }

        if ($types->count() === 1) {
            return $types->first();
        }

        if ($types->every(fn (string $type): bool => in_array($type, ['integer', 'float'], true))) {
            return 'float';
        }

        if ($types->every(fn (string $type): bool => in_array($type, ['date', 'datetime'], true))) {
            return $types->contains('datetime') ? 'datetime' : 'date';
        }

        return 'string';
    }

    private function inferValueType(mixed $value): string
    {
        if ($value === null) {
            return 'null';
        }

        if ($value instanceof DateTimeInterface) {
            return 'datetime';
        }

        if (is_bool($value)) {
            return 'boolean';
        }

        if (is_int($value)) {
            return 'integer';
        }

        if (is_float($value)) {
            return 'float';
        }

        if (! is_string($value)) {
            return get_debug_type($value);
        }

        $trimmed = trim($value);

        if ($trimmed === '') {
            return 'null';
        }

        if (in_array(strtolower($trimmed), ['true', 'false', 'yes', 'no'], true)) {
            return 'boolean';
        }

        if (preg_match('/^-?(?:0|[1-9]\d*)$/', $trimmed) === 1) {
            return 'integer';
        }

        if (preg_match('/^-?(?:(?:0|[1-9]\d*)\.\d+|\d+(?:\.\d+)?e[+-]?\d+)$/i', $trimmed) === 1) {
            return 'float';
        }

        if ($this->looksLikeDateTimeString($trimmed)) {
            return str_contains($trimmed, ':') ? 'datetime' : 'date';
        }

        return 'string';
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     */
    private function isBooleanColumn(array $rows, string $header): bool
    {
        $values = collect($rows)
            ->map(fn (array $row): mixed => $row[$header] ?? null)
            ->reject(fn (mixed $value): bool => $this->inferValueType($value) === 'null')
            ->values();

        if ($values->isEmpty()) {
            return false;
        }

        return $values->every(fn (mixed $value): bool => $this->isBooleanLikeValue($value));
    }

    private function isBooleanLikeValue(mixed $value): bool
    {
        if (is_bool($value)) {
            return true;
        }

        if (is_int($value) || is_float($value)) {
            return in_array((string) $value, ['0', '1'], true);
        }

        if (! is_string($value)) {
            return false;
        }

        return in_array(strtolower(trim($value)), ['0', '1', 'true', 'false', 'yes', 'no'], true);
    }

    private function looksLikeDateTimeString(string $value): bool
    {
        if (! preg_match('/[\/\-\:T]/', $value)) {
            return false;
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return false;
        }

        $parsed = date_parse($value);

        if (($parsed['error_count'] ?? 0) > 0) {
            return false;
        }

        return ($parsed['year'] ?? false) !== false
            && ($parsed['month'] ?? false) !== false
            && ($parsed['day'] ?? false) !== false;
    }
}
