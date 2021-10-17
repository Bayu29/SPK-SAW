<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegrityDeviationsTable extends Migration
{
    public function up()
    {
        Schema::create('integrity_deviations', function (Blueprint $table) {
            $table->id();
            $table->integer('deviation');
            $table->float('integrity');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('integrity_deviations');
    }
}
