<?php

use App\Jobs\AnalyseFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('it stores inferred column types and row counts for csv datasets', function () {
    Storage::fake('public');

    $user = User::query()->create([
        'username' => 'dataset-owner',
        'email' => 'owner@example.com',
        'password' => 'password',
    ]);

    $csv = <<<'CSV'
id,name,amount,active
1,Ada,10.50,true
2,Grace,25.00,false
CSV;

    Storage::disk('public')->put('datasets/report.csv', $csv);

    (new AnalyseFile($user, 'report.csv', 'datasets/report.csv'))->handle();

    $dataset = $user->datasets()->sole();

    expect($dataset->row_count)->toBe(2)
        ->and($dataset->columns_count)->toBe(4)
        ->and(json_decode($dataset->columns, true))->toBe([
            ['name' => 'id', 'type' => 'integer'],
            ['name' => 'name', 'type' => 'string'],
            ['name' => 'amount', 'type' => 'float'],
            ['name' => 'active', 'type' => 'boolean'],
        ]);
});
