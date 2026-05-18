<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_data_columns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_to_show')->unique();
            $table->string('data_type')->nullable();
            $table->boolean('required')->default(false);
            $table->string('default_value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_data_columns');
    }
};
