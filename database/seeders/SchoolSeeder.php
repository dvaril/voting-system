<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Jobs\ImportSchoolDatasetJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

final class SchoolSeeder extends Seeder
{


    public function run(): void
    {
        $baseDirectory = storage_path('schools');
        File::ensureDirectoryExists($baseDirectory);
        $files = File::files($baseDirectory);

        if (empty($files)) {
            $this->command->info("No schools files found.");

            return;
        }

        $this->command->info('Seeding schools...');


        dispatch(new ImportSchoolDatasetJob(
            $baseDirectory . "/adresar_JMK_30102024.xlsx",
            [
                'name' => 'Plný název',
                'city' => 'Název ORP',
                'district' => 'Okres'
            ]
        ));

        $this->command->info('Schools are seeded...');
    }
}
