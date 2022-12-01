<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
        CREATE TRIGGER `Hasil_Laut_Triggerd_Update` AFTER INSERT ON `keranjang` FOR EACH ROW 
            BEGIN
                UPDATE hasil_laut SET qty = qty - NEW.qty
                WHERE id = NEW.id_product;
            END
        ');

        DB::unprepared('
        CREATE TRIGGER `Hasil_Laut_Triggerd_Delete` AFTER DELETE ON `keranjang` FOR EACH ROW 
            BEGIN
                UPDATE hasil_laut SET qty = qty + OLD.qty
                WHERE id = OLD.id_product;
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
        DB::unprepared('DROP TRIGGER `Hasil_Laut_Triggerd_Update`'); 
        DB::unprepared('DROP TRIGGER `Hasil_Laut_Triggerd_Delete`'); 
    }
};
