<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->string('inference_method')->nullable()->after('is_emergency');
            $table->integer('matched_symptoms_count')->default(0)->after('inference_method');
            $table->text('disease_description')->nullable()->after('matched_symptoms_count');
            $table->text('treatment')->nullable()->after('disease_description');
            $table->text('prevention')->nullable()->after('treatment');
            $table->string('severity')->default('low')->after('prevention');
        });
    }

    public function down()
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->dropColumn([
                'inference_method',
                'matched_symptoms_count', 
                'disease_description',
                'treatment',
                'prevention',
                'severity'
            ]);
        });
    }
};