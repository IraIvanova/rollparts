<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class UpdateSearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:update-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index('products');

        $index->updateFilterableAttributes([
            'category_ids',
            'discounted_price',
            'car_model_ids',
            'make_names',
            'car_model_names',
            'id',
        ]);

        $index->updateSortableAttributes([
            'id',
            'discounted_price',
            'name'
        ]);
    }
}
