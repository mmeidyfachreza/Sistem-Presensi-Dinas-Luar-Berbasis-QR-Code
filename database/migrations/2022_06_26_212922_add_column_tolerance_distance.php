<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('field_work_activities', function (Blueprint $table) {
            $table->integer('tolerance_distance')->after('geo_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_work_activities', function (Blueprint $table) {
            $table->dropColumn('tolerance_distance');
        });
    }
};
