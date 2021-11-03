<?php

namespace App\Console\Commands;

use Domain\Sales\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EndSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End running / active sales';

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
            ->where('ends_on', now()->toDateTimeString())
            ->get();

        $sales->each(function ($sale) {
            $sale->changeState('ended');

            $sale->skus->chunk(100)->each(function ($skus) {
                try {
                    DB::beginTransaction();

                    foreach ($skus as $sku) {
                        $sku->discount_percentage = null;
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
