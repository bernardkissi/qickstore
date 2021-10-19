<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProductStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW `stores`.`product_stock_view` AS
            SELECT
                `p`.`id` AS `sku_id`,
                `p`.`uuid` AS `uuid`,
                `o`.`quantity` AS `ordered`,
                coalesce((sum(`s`.`quantity`) - coalesce(sum(`o`.`quantity`), 0)), 0) AS `stock`,
                (
                    CASE WHEN (coalesce((sum(`s`.`quantity`) - coalesce(sum(`o`.`quantity`), 0))) > 0) THEN
                        true
                    else
                        false
                    END) as `in_stock`
            FROM ((`stores`.`skus` `p`
                LEFT JOIN (
                    SELECT
                        `stores`.`stocks`.`sku_id` AS `id`,
                        sum(`stores`.`stocks`.`quantity`) AS `quantity`
                    FROM
                        `stores`.`stocks`
                    GROUP BY
                        `stores`.`stocks`.`sku_id`) `s` ON ((`p`.`id` = `s`.`id`)))
                LEFT JOIN (
                    SELECT
                        `stores`.`product_order`.`sku_id` AS `id`,
                        sum(`stores`.`product_order`.`quantity`) AS `quantity`
                    FROM
                        `stores`.`product_order`
                    GROUP BY
                        `stores`.`product_order`.`sku_id`) `o` ON ((`p`.`id` = `o`.`id`)))
            GROUP BY
                `p`.`id`
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `stores`.`product_stock_view`');
    }
}
