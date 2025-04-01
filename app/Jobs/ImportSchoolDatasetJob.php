<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\ImportException;
use App\Models\School;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelReader;

final class ImportSchoolDatasetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var list<string>
     */
    private static array $allowedFileExtensions = [
        'csv',
        'xlsx',
        'xls'
    ];

    public function __construct(
        private readonly string $filePath,
        /** @var array<string, string> */
        private readonly array $columnMap,
        private readonly string $delimiter = ", ",
        private readonly int $batchSize = 5000,
    ) {}

    /**
     * @return void
     * @throws ImportException
     */
    public function handle(): void
    {
        $this->assertFileValid();

        SimpleExcelReader::create($this->filePath)
            ->useDelimiter($this->delimiter)
            ->getRows()
            ->chunk($this->batchSize)
            ->each(fn (LazyCollection $chunk) => $chunk->each($this->processChunkRow(...)));
    }

    /**
     * @param  array<string, mixed> $rowData
     * @return void
     * @throws ImportException
     */
    private function processChunkRow(array $rowData): void
    {
        $data = [];

        foreach ($this->columnMap as $attributeKey => $sheetColumnKey) {
            if (array_key_exists($sheetColumnKey, $rowData)) {
                $data[$attributeKey] = $rowData[$sheetColumnKey];
            } else {
                throw ImportException::columnNotFoundInSheet($sheetColumnKey, array_values($this->columnMap));
            }
        }

        if (! empty($data)) {
            School::query()->create($data);
        }
    }

    /**
     * @return void
     * @throws ImportException
     */
    private function assertFileValid(): void
    {
        $fileExtension = strtolower(pathinfo($this->filePath, PATHINFO_EXTENSION));

        if (! File::exists($this->filePath)) {
            throw ImportException::fileDoesntExist($this->filePath);
        }

        if (! in_array($fileExtension, self::$allowedFileExtensions, true)) {
            throw ImportException::invalidFileExtension($this->filePath, $fileExtension, self::$allowedFileExtensions);
        }
    }
}
