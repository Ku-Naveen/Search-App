<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RebuildSearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:rebuild-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush and re-import all searchable models';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $models = [
            \App\Models\Blog::class,
            \App\Models\Products::class,
            \App\Models\Pages::class,
            \App\Models\Faqs::class,
        ];

         foreach ($models as $model) {
            $this->info("Flushing: $model");
            Artisan::call('scout:flush', ['model' => $model]);
            $this->info("Importing: $model");
            Artisan::call('scout:import', ['model' => $model]);
        }

        $this->info('✅ Search indexes rebuilt successfully.');
    }
}
