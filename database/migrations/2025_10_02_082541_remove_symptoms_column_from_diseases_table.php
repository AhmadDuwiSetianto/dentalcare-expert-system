<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('diseases', function (Blueprint $table) {
            if (Schema::hasColumn('diseases', 'symptoms')) {
                $table->dropColumn('symptoms');
            }
        });
    }

    public function down()
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->text('symptoms')->nullable();
        });
    }
};