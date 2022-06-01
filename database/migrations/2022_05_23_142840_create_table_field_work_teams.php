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
        Schema::create('field_work_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_work_activity_id')->constrained();
            $table->foreignId('employee_id')->constrained();
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
        Schema::table('field_work_teams', function(Blueprint $table){
            $table->dropForeign(['field_work_activity_id']);
            $table->dropForeign(['employee_id']);
        });
        Schema::dropIfExists('field_work_teams');
    }
};
