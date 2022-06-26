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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_work_activity_id')->constrained()->cascadeOnDelete();
            $table->string('codewords');
            $table->boolean('active')->default(true);
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
        Schema::table('qrcodes', function(Blueprint $table){
            $table->dropForeign(['field_work_activity_id']);
        });
        Schema::dropIfExists('qrcodes');
    }
};
