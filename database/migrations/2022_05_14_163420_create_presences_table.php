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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('field_work_activity_id')->constrained();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('start_location');
            $table->string('end_location')->nullable();
            $table->string('work_duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presences', function(Blueprint $table){
            $table->dropForeign(['field_work_activity_id']);
            $table->dropForeign(['employee_id']);
        });
        Schema::dropIfExists('presences');
    }
};
