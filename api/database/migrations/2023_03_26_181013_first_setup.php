<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        DB::statement("create table options2
(
    option_id int auto_increment primary key,
    name      varchar(40) null,
    value     longtext    null
)
    charset = utf8mb4;
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
