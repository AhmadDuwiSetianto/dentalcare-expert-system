<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disease_symptom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained()->onDelete('cascade');
            $table->foreignId('symptom_id')->constrained()->onDelete('cascade');
            $table->integer('weight')->default(1);
            $table->timestamps();
            
            $table->unique(['disease_id', 'symptom_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('disease_symptom');
    }
};