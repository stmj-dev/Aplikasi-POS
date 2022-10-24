<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            DB::unprepared('
                CREATE TRIGGER `stock_subtract` AFTER INSERT on `transactions` FOR EACH ROW
                BEGIN
                    UPDATE products SET stock=stock-NEW.count_product where id=NEW.product_id;
                END
            ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER "stock_subtract"');
    }
};
