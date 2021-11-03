<?php

namespace App\Console\Commands;

use Domain\Sales\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RunSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs all users sales';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sales = Sale::query()
            ->where('starts_on', now()->toDateTimeString())
            ->get();

        $sales->each(function ($sale) {
            $sale->changeState('active');

            $sale->skus->chunk(100)->each(function ($skus) use ($sale) {
                try {
                    DB::beginTransaction();

                    foreach ($skus as $sku) {
                        $sku->discount_percentage = $sale->percentage_reduction;
                        $sku->save();
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            });
        });
    }
}
