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
        Schema::create('field_work_activities', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('description');
            $table->string('pic_name');
            $table->string('pic_position');
            $table->string('pic_email');
            $table->string('pic_phone_number');
            $table->string('address');
            $table->string('geo_location');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('link');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_work_activities');
    }
};
