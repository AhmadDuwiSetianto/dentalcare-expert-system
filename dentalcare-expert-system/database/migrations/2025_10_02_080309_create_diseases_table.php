<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            // HAPUS BARIS INI: $table->text('symptoms');
            $table->text('treatment');
            $table->text('prevention');
            $table->text('causes');
            $table->text('risk_factors');
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->boolean('is_emergency')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diseases');
    }
};